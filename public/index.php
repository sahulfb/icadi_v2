<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AlumnosController;
use Controllers\AuthController;
use Controllers\ConsultasController;
use Controllers\CursosController;
use Controllers\DashboardController;
use Controllers\DiplomasController;
use Controllers\PaginasController;
use Controllers\PlantillasController;
use MVC\Router;

$router = new Router();

$router->get('/',[AuthController::class, 'index']);
$router->post('/',[AuthController::class, 'index']);

// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

//Consultas BD
$router->post('/validar', [ConsultasController::class, 'validarDiplomas']);
$router->get('/validar/resultado', [ConsultasController::class, 'validarResultados']);
$router->post('/mostrar-certificados', [ConsultasController::class, 'mostrarCertificados']);
$router->post('/api/cambiar-status', [ConsultasController::class, 'cambiarStatus']);


//Area publica
$router->get('/', [PaginasController::class, 'index']);
$router->get('/404',[PaginasController::class, 'NoEncontrado']);

//Area de Administracion
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/alumnos', [AlumnosController::class, 'index']);
$router->get('/admin/alumnos/crear', [AlumnosController::class, 'crear']);
$router->post('/admin/alumnos/crear', [AlumnosController::class, 'crear']);
$router->get('/admin/alumnos/editar', [AlumnosController::class, 'editar']);
$router->post('/admin/alumnos/editar', [AlumnosController::class, 'editar']);
$router->post('/admin/alumnos/eliminar', [AlumnosController::class, 'eliminar']);

$router->get('/admin/cursos', [CursosController::class, 'index']);
$router->get('/admin/cursos/crear', [CursosController::class, 'crear']);
$router->post('/admin/cursos/crear', [CursosController::class, 'crear']);
$router->get('/admin/cursos/editar', [CursosController::class, 'editar']);
$router->post('/admin/cursos/editar', [CursosController::class, 'editar']);
$router->post('/admin/cursos/eliminar', [CursosController::class, 'eliminar']);

$router->get('/admin/diplomas', [DiplomasController::class, 'index']);
$router->get('/admin/diplomas/crear', [DiplomasController::class, 'crear']);
$router->post('/admin/diplomas/crear', [DiplomasController::class, 'crear']);
$router->get('/admin/diplomas/editar', [DiplomasController::class, 'editar']);
$router->post('/admin/diplomas/editar', [DiplomasController::class, 'editar']);
$router->post('/admin/diplomas/eliminar', [DiplomasController::class, 'eliminar']);

$router->get('/admin/plantillas', [PlantillasController::class, 'index']);
$router->get('/admin/plantillas/crear', [PlantillasController::class, 'crear']);
$router->post('/admin/plantillas/crear', [PlantillasController::class, 'crear']);
$router->post('/admin/plantillas/eliminar', [PlantillasController::class, 'eliminar']);

$router->get('/api/alumno', [AlumnosController::class, 'apiAlumno']);

$router->comprobarRutas();