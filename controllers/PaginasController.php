<?php

namespace Controllers;

use Classes\Email;
use Model\Alumno;
use Model\Usuario;
use MVC\Router;

class PaginasController {

public static function index(Router $router){
        $alertas = [];
          $router->render('paginas/index', [
            'titulo' => 'Validación de Certificados Académicos',
            'alertas' => $alertas,
        ]);
    }

    public static function NoEncontrado(Router $router){
      $router->render('paginas/404',[
      ]);
    }
}