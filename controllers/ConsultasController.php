<?php

namespace Controllers;

use Classes\Certificado;
use Model\Alumno;
use Model\Curso;
use Model\Diploma;
use Model\Plantilla;
use Model\Usuario;
use MVC\Router;

class ConsultasController {

  public static function validarDiplomas(Router $router)
  {
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
          $token=$_POST['token'];
          $url='https://www.google.com/recaptcha/api/siteverify';
          $peticion=$url.'?secret='.$_ENV["PRIVADA"].'&response='.$token;
          $resp=file_get_contents($peticion);
          $json=json_decode($resp,true);
          $ok=$json['success'];
      if($ok===false || (isset($json['score']) && $json['score'] < 0.7)){
          header('Location: /');
      }else{
            $pasaporte=$_POST['pasaporte'];
            if(!$pasaporte){
              Alumno::setAlerta('error','El pasaporte es obligatorio');
              $alertas= Usuario::getAlertas();
              $router->render('paginas/index', [
                'alertas' => $alertas,
                'titulo' => 'Validación de Certificados Académicos',
              ]);
            }
            
            if($_POST['codigo']){
              $codigo=$_POST['codigo'];
              $validarC=Alumno::validarCodigo($pasaporte,$codigo);
                    if(empty($validarC)){
                      Alumno::setAlerta('error','Alumno no registrado o diploma anulado');
                      $alertas= Alumno::getAlertas();
                      $router->render('paginas/index', [
                        'alertas' => $alertas,
                        'titulo' => 'Validación de Certificados Académicos',
                    ]);
                    }else{
                      $resultado=Alumno::obtenerCertificado($codigo);
                      $plantilla= Plantilla::where("id",$resultado["plantilla_id"]);
                      $certificado = new Certificado($resultado,$plantilla->plantilla);
                      $certificado->generarCertificado();
                    }
                    
              }elseif($_POST['fecha']){
                $validarF=Alumno::validarFecha($pasaporte,$_POST['fecha']);
                  if(empty($validarF)){
                    Alumno::setAlerta('error','Alumno no registrado');
                    $alertas= Alumno::getAlertas();
                    $router->render('paginas/index', [
                      'alertas' => $alertas,
                      'titulo' => 'Validación de Certificados Académicos',
                  ]);
                  }else{
                    $alumno=Alumno::where("pasaporte",$pasaporte);
                    $pasaporte = $_POST['pasaporte'];
                    $fecha = $_POST['fecha'];
                    $tokenAlumno = $alumno->token;
                    $data = 'id=' . $pasaporte . '&fecha=' . $fecha . '&token=' . $tokenAlumno;
                    $key=$_ENV['APP_KEY'];
                    $tokenEncriptado = self::encriptarToken($data, $key);
                    header('Location: validar/resultado?token=' . urlencode($tokenEncriptado));
                  }
                    
              }else{
                Alumno::setAlerta('error','Ingresar pasaporte y medio de verificacion');
                $alertas= Usuario::getAlertas();
                $router->render('paginas/index', [
                  'alertas' => $alertas,
                  'titulo' => 'Validación de Certificados Académicos',
              ]);
              }

          }}
  }

    public static function validarResultados(Router $router){
      $key = $_ENV['APP_KEY'];
      $token=s($_GET["token"]);
      $tokenDesencriptado = self::desencriptarToken($token, $key);
      $id = $tokenDesencriptado['id'];
      $fecha = $tokenDesencriptado['fecha'];
      $tokenAlumno = $tokenDesencriptado['token'];
      $alumno=Alumno::where("pasaporte",$id);
      if($alumno->token!==$tokenAlumno && $_SERVER['REQUEST_METHOD']!== 'POST'){
        header('Location: /');
      }
          $diplomas=Diploma::obtenerCertificadoFecha($alumno->id);
             // Generar el Token
             $alumno->token=uniqid();
             $alumno->guardar();
      $router->render('paginas/resultados', [
        'titulo' => 'Lista de Cursos Alumnado',
        'diplomas' => $diplomas,
        'alumno' => $alumno,
    ]);
  }

  public static function mostrarCertificados(){
      if($_SERVER['REQUEST_METHOD']=== 'POST'){
        $codigo=$_POST['codigo'];
        $resultado=Alumno::obtenerCertificado($codigo);
        $plantilla= Plantilla::where("id",$resultado["plantilla_id"]);
      $certificado = new Certificado($resultado,$plantilla->plantilla);
      $certificado->generarCertificado();
    }
  }

  public static function cambiarStatus() {
    header('Content-Type: application/json');
    $ruta = isset($_POST['ruta']) ? $_POST['ruta'] : null;
    $estatus = isset($_POST['estatus']) ? $_POST['estatus'] : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    switch ($ruta) {
        case '/admin/alumnos':
            Alumno::UpdateStatus($id,$estatus);
            break;
        case '/admin/cursos':
            Curso::UpdateStatus($id,$estatus);
            break;
        case '/admin/diplomas':
            Diploma::UpdateStatus($id,$estatus);
            break;
        default:
            echo json_encode(array('error' => 'Ruta no válida'), JSON_UNESCAPED_SLASHES);
            return;
    }

    $alumno = array('result' => 'Actualización realizada');
    echo json_encode($alumno, JSON_UNESCAPED_SLASHES);
}

  public static function encriptarToken($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
  }

  public static function desencriptarToken($tokenEncriptado, $key) {
    list($encriptadoData, $iv) = explode('::', base64_decode($tokenEncriptado), 2);
    $dataDesencriptada = openssl_decrypt($encriptadoData, 'aes-256-cbc', $key, 0, $iv);
    parse_str($dataDesencriptada, $resultado);
    return $resultado;
  }


}