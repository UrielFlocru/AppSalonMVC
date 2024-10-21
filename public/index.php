<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\AppointmentController;
use Controllers\LoginController;
use Controllers\ServicesController;
use MVC\Router;

$router = new Router();

//Iniciar Sesión
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//Recuperar password
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->post('/forgot', [LoginController::class, 'forgot']);
$router->get('/reset', [LoginController::class, 'reset']);
$router->post('/reset', [LoginController::class, 'reset']);

//Crear cuenta
$router->get('/register', [LoginController::class, 'register']);
$router->post('/register', [LoginController::class, 'register']);

//Confirmar cuenta
$router->get('/confirm', [LoginController::class, 'confirm']);
$router->get('/message', [LoginController::class, 'message']);

//Area privada
$router->get('/appointment', [AppointmentController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//API citas
$router->get('/api/services', [APIController::class, 'index']);
$router->post('/api/appointment', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

//CRUD de servicios
$router->get('/services',[ServicesController::class,'index']);
$router->get('/services/create',[ServicesController::class,'create']);
$router->post('/services/create',[ServicesController::class,'create']);
$router->get('/services/update',[ServicesController::class,'update']);
$router->post('/services/update',[ServicesController::class,'update']);
$router->get('/services/delete',[ServicesController::class,'delete']);
$router->post('/services/delete',[ServicesController::class,'delete']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();