<?php

namespace Controllers;

use Classes\Certificado;
use Model\Alumno;
use Model\Curso;
use Model\Evento;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController {
    public static function index(Router $router){
        if(!is_auth()){
            header('Location: /login');
        };
        $alumnos=Alumno::total();
        $cursos=Curso::total();
        $router->render('admin/dashboard/index',[
            'titulo'=>'Panel de Administración',
            'alumnos'=>$alumnos,
            'cursos'=>$cursos,
        ]);
    }
}