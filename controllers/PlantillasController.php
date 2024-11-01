<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Plantilla;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class PlantillasController {

    public static function index(Router $router){
        if(!is_auth()){
            header('Location: /login');
        };
        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
    
        if(!$pagina_actual || $pagina_actual < 1) {
            $pagina_actual = 1;
        }
    
        $registros_por_pagina = 5;
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';
        $total= Plantilla::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total, $query);
    
        if($paginacion->total_paginas() < $pagina_actual) {
            $pagina_actual = 1;
        }
        if ($query) {
            $columnas = ['nombre'];
            $plantillas = Plantilla::whereLike($columnas, $query);
            $total = count($plantillas);
            $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total, $query);
            $plantillas = array_slice($plantillas, $paginacion->offset(), $registros_por_pagina);
        } else {
        $plantillas= Plantilla::paginar($registros_por_pagina,$paginacion->offset());
        }
              $router->render('admin/plantillas/index', [
                'titulo' => 'Plantillas',
                'paginacion'=>$paginacion->paginacion(),
                'plantillas' => $plantillas
            ]);
        }

        public static function crear(Router $router){
            if(!is_auth()){
                header('Location: /login');
            };
            $alertas = [];
            $plantilla = new Plantilla;
            
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if(!is_auth()){
                    header('Location: /login');
                };
                
                $carpeta_img = '../public/plantillas';
        
                // Leer Imagen
                if(!empty($_FILES['plantilla']['tmp_name'])){
                    // Crear la carpeta si no existe
                    if(!is_dir($carpeta_img)){
                        mkdir($carpeta_img, 0755, true);
                    }
                    $img = $_FILES['plantilla']['tmp_name'];
        
                    // Verificar que la imagen fue leída correctamente
                    if ($img && file_exists($img)) {
                        $nombre_img = md5(uniqid(rand(), true));
                        $_POST['plantilla'] = $nombre_img;
                        $plantilla->sincronizar($_POST);
                        $alertas = $plantilla->validar();
        
                        // Guardar el registro
                        if(empty($alertas)){
                            // Procesar la imagen
                            $image = Image::make($img)
                                ->resize(1056, 816)
                                ->encode('jpg', 75); 
                            
                            // Guardar la imagen
                            $image->save($carpeta_img . "/" . $nombre_img . ".jpg");
                            
                            // Guardar en la BD
                            $resultado = $plantilla->guardar();
                            if($resultado){
                                header('Location: /admin/plantillas');
                            }
                        }
                    } else {
                        Plantilla::setAlerta('error', 'Error al leer la imagen. Por favor, inténtalo de nuevo.');
                        $alertas = Plantilla::getAlertas();
                    }
                }
            }
        
            $router->render('admin/plantillas/crear', [
                'titulo' => 'Subir Plantilla',
                'alertas' => $alertas,
                'plantilla' => $plantilla,
            ]);
        }
        

        public static function eliminar()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!is_admin()) {
                    header('Location: /login');
                }
    
                $id = $_POST['id'];
                $plantilla = Plantilla::find($id);
                if (empty($id) || !isset($plantilla)) {
                    header('Location: /admin/plantillas');
                }
    
                $resultado = $plantilla->eliminar();
                $eliminarImg = eliminarImagen($plantilla->plantilla);
                if ($resultado) {
                    header('Location: /admin/plantillas');
                }
            }
        }
}