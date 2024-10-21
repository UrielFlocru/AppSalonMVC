<?php

namespace Controllers;

use Model\Service;
use MVC\Router;
class ServicesController {


    public static function index (Router $router){
        session_start();
        isAdmin();

        $services = Service::all();
        
        $router->render('services/index',[
            'name' => $_SESSION['name'],
            'services' => $services
        ]);
    }

    public static function create (Router $router){
        session_start();
        isAdmin();
        $service = new Service();
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $service->sincronizar($_POST);

            $alerts= $service->validate();

            if (empty($alerts)){
                $service->guardar();
                header('Location: /services');
            }

        }
        
        $router->render('services/create',[
            'name' => $_SESSION['name'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }
    public static function update (Router $router){
        session_start();
        isAdmin();

        if (!is_numeric($_GET['id'])) return;
        $service = Service::find($_GET['id']);
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $service->sincronizar($_POST);

            $alerts = $service->validate();
            
            if (empty($alerts)){
                $service->guardar();
                header('Location: /services');
            }
        }

        $router->render('services/update',[
            'name' => $_SESSION['name'],
            'alerts' => $alerts,
            'service' => $service
        ]);
    }
    public static function delete (){
        session_start();
        isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $id = $_POST['id'];
            $service = Service::find($id);
            
            $service->eliminar();
            header('Location: /services');
        }

    }
}