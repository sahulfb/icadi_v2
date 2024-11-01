<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Alumno;
use Model\Curso;
use Model\Diploma;
use Model\Plantilla;
use MVC\Router;

class DiplomasController {

public static function index(Router $router){
    if(!is_auth()){
        header('Location: /login');
    };

    $pagina_actual = $_GET['page'] ?? 1;
    $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

    if(!$pagina_actual || $pagina_actual < 1) {
        $pagina_actual = 1;
    }

    $registros_por_pagina = 10;
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';
    $total = Diploma::total();
    $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total, $query);
    
    if($paginacion->total_paginas() < $pagina_actual) {
        $pagina_actual = 1;
    }
    if ($query) {
        $columnas = ['a.nombre', 'c.name_curso', 'p.nombre', 'd.codigo'];
        $diplomas = Diploma::buscarConJoin($columnas, $query);
        $total = count($diplomas);
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total, $query);
        $diplomas = array_slice($diplomas, $paginacion->offset(), $registros_por_pagina);
    } else {
    $diplomas=Diploma::listaDiplomas($registros_por_pagina, $paginacion->offset());
    }
          $router->render('admin/diplomas/index', [
            'titulo' => 'Diplomas',
            'paginacion' => $paginacion->paginacion(),
            'diplomas'=>$diplomas,
        ]);
    }

    public static function crear(Router $router){
        if(!is_auth()){
            header('Location: /login');
        };
    
        $alertas = [];
        $cursos = Curso::allVigente();
        $plantillas = Plantilla::all('ASC');
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $isEditRoute = false; // Siempre falso para el método crear
        $diploma = new Diploma;
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };
    
            $alumno_pas = $_POST['alumno_pas'];
             $alumno_nombre =$_POST['alumno_nombre'];
            if(!empty($alumno_pas) && !empty($alumno_nombre)){
                $resultado = Alumno::existeAlumnoPas($alumno_pas);
            }else{
                Diploma::setAlerta('error', 'Debe ingresar algun alumno existente');
                $alertas = Diploma::getAlertas();
            }
            $alumno_id = $resultado['id'];
            $diploma->token = uniqid();
            $alumn_id = Diploma::buscarId($_POST["codigo"]);
    
            if(!empty($alumn_id)) {
                Diploma::setAlerta('error', 'Código registrado');
                $alertas = Diploma::getAlertas();
            } else {
                $diploma->alumno_id = $alumno_id;
                $diploma->sincronizar($_POST);
                $alertas = $diploma->validar();
    
                $resultadoB = $diploma->existeRegistro();
                if($resultadoB->num_rows) {
                    $alertas = Diploma::getAlertas();
                } else {
                    if(empty($alertas)){
                        $resultado = $diploma->guardar();
                        if($resultado){
                            header('Location: /admin/diplomas');
                        }
                    }
                }
            }
        }
    
        $router->render('admin/diplomas/crear',[
            'titulo' => 'Registrar Diploma',
            'alertas' => $alertas,
            'diploma' => $diploma,
            'cursos' => $cursos,
            'plantillas' => $plantillas,
            'isEditRoute' => $isEditRoute
        ]);
    }
    

    public static function editar(Router $router){
        if(!is_auth()){
            header('Location: /login');
        };
        
        $alertas=[];
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /admin/diplomas');
        }
        
        $cursos = Curso::allVigente();
        $plantillas = Plantilla::all('ASC');
        $diploma = Diploma::find($id);
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $isEditRoute = ($uri == '/admin/diplomas/editar');
        
        if(!$diploma){
            header('Location: /admin/diplomas');
        }
    
        // Obtener datos del alumno
        $alumno = Alumno::find($diploma->alumno_id);
        if($alumno) {
            $diploma->alumno_pas = $alumno->pasaporte;
            $diploma->alumno_nombre = $alumno->nombre;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };
            
            $diploma->sincronizar($_POST);
            $alertas = $diploma->validar();
            
            if(empty($alertas)){
                $resultado = $diploma->guardar();
                if($resultado){
                    header('Location: /admin/diplomas');
                }
            }
        }
        
        $router->render('admin/diplomas/editar',[
            'titulo' => 'Editar Diploma',
            'alertas' => $alertas,
            'diploma' => $diploma,
            'cursos' => $cursos,
            'plantillas' => $plantillas,
            'isEditRoute' => $isEditRoute
        ]);
    }
    

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            if(!is_auth()){
                header('Location: /login');
            };

            $id=$_POST['id'];
            $diploma= Diploma::find($id);
            if(!isset($diploma)){
                header('Location: /admin/diplomas');
            }

            $resultado=$diploma->eliminar();

            if($resultado){
                header('Location: /admin/diplomas');
            }
        }
    }
}