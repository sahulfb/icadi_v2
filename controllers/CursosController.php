<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Curso;
use Model\Usuario;
use MVC\Router;

class CursosController {

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
        $total = Curso::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total, $query);
        
        if($paginacion->total_paginas() < $pagina_actual) {
            $pagina_actual = 1;
        }
        if ($query) {
            $columnas = ['name_curso','colaborador'];
            $cursos = Curso::whereLike($columnas, $query);
            $total = count($cursos);
            $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total, $query);
            $cursos = array_slice($cursos, $paginacion->offset(), $registros_por_pagina);
        } else {
        $cursos = Curso::paginar($registros_por_pagina, $paginacion->offset());
        }
        $router->render('admin/cursos/index', [
            'titulo' => 'Cursos',
            'paginacion' => $paginacion->paginacion(),
            'cursos' => $cursos
        ]);
    }
    

    public static function crear(Router $router){
        if(!is_auth()){
            header('Location: /login');
        };
        $alertas=[];
        $curso= new Curso;

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };
            $curso->sincronizar($_POST);
            $alertas= $curso->validar();
            $resultado=$curso->existeCurso();
            if($resultado->num_rows) {
                $alertas = Curso::getAlertas();
            } else {
                if(empty($alertas)){
                    $resultado=$curso->guardar();
                    if($resultado){
                        header('Location: /admin/cursos');
                    }
                }
                }
            }

        $router->render('admin/cursos/crear',[
            'titulo'=>'Registrar Curso',
            'alertas'=>$alertas,
            'curso'=>$curso,
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
            header('Location: /admin/cursos');
        }

        $curso= Curso::find($id);

        if(!$curso){
            header('Location: /admin/cursos');
        }

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };

            $curso->sincronizar($_POST);

            $alertas= $curso->validar();

            if(empty($alertas)){
                $resultado=$curso->guardar();
                if($resultado){
                    header('Location: /admin/cursos');
                }
            }
        }

        $router->render('admin/cursos/editar',[
            'titulo'=>'Editar Curso',
            'alertas'=>$alertas,
            'curso'=>$curso,
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };

            $id=$_POST['id'];
            $curso= Curso::find($id);
            if(!isset($curso)){
                header('Location: /admin/cursos');
            }

            $resultado=$curso->eliminar();

            if($resultado){
                header('Location: /admin/cursos');
            }
        }
    }
}