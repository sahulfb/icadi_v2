<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Alumno;
use MVC\Router;

class AlumnosController {
    public static function index(Router $router) {
        if(!is_auth()) {
            header('Location: /login');
        }
    
        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1) {
            $pagina_actual = 1;
        }
    
        $registros_por_pagina = 10;
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';
        $total = Alumno::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total, $query);
    
        if($paginacion->total_paginas() < $pagina_actual) {
            $pagina_actual = 1;
        }
    
        if ($query) {
            $columnas = ['nombre','pasaporte', 'email'];
            $alumnos = Alumno::whereLike($columnas, $query);
            $total = count($alumnos);
            $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total, $query);
            $alumnos = array_slice($alumnos, $paginacion->offset(), $registros_por_pagina);
        } else {
            $alumnos = Alumno::paginar($registros_por_pagina, $paginacion->offset());
        }
    
        $router->render('admin/alumnos/index', [
            'titulo' => 'Alumnos',
            'paginacion' => $paginacion->paginacion(),
            'alumnos' => $alumnos,
            'query' => $query // Pass the sanitized query to the view
        ]);
    }
    
    

    public static function crear(Router $router){
        if(!is_auth()){
            header('Location: /login');
        };
        $alertas=[];
        $alumno= new Alumno;

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };
            $alumno->token=uniqid();
            $alumno->sincronizar($_POST);
            $alertas= $alumno->validar();
            $resultado=$alumno->existeAlumno();
            if($resultado->num_rows) {
                $alertas = Alumno::getAlertas();
            } else {
                if(empty($alertas)){
                    $resultado=$alumno->guardar();
                    if($resultado){
                        header('Location: /admin/alumnos');
                    }
                }
            }

        }

        $router->render('admin/alumnos/crear',[
            'titulo'=>'Registrar Alumno',
            'alertas'=>$alertas,
            'alumno'=>$alumno,
        ]);
    }

    public static function editar(Router $router){
        if(!is_auth()){
            header('Location: /login');
        };
        $alertas=[];
        $id=$_GET['id'];
        $id=filter_var($id,FILTER_VALIDATE_INT);

        if(!$id){
            header('Location: /admin/alumnos');
        }

        $alumno= Alumno::find($id);

        if(!$alumno){
            header('Location: /admin/alumnos');
        }

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };

            $alumno->sincronizar($_POST);

            $alertas= $alumno->validar();

            if(empty($alertas)){
                $resultado=$alumno->guardar();
                if($resultado){
                    header('Location: /admin/alumnos');
                }
            }
        }

        $router->render('admin/alumnos/editar',[
            'titulo'=>'Editar Alumno',
            'alertas'=>$alertas,
            'alumno'=>$alumno,
        ]);
    }

    public static function apiAlumno(){
        $id=$_GET['id'];
        $id=filter_var($id,FILTER_VALIDATE_INT);

        if(!$id || $id < 1){
            echo json_encode([]);
            return;
        }

        $alumno= Alumno::findPas($id);
        if(!isset($alumno)){
            echo json_encode([]);
            return;
        }
        echo json_encode($alumno, JSON_UNESCAPED_SLASHES);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };

            $id=$_POST['id'];
            $alumno= Alumno::find($id);
            if(!isset($alumno)){
                header('Location: /admin/alumnos');
            }

            $resultado=$alumno->eliminar();

            if($resultado){
                header('Location: /admin/alumnos');
            }
        }
    }
}