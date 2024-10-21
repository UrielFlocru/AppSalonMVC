<?php

namespace Controllers;

use Model\Appointment;
use Model\AppointmentsServices;
use Model\Service;

class APIController {
    public static function index (){
        $services = Service::all();
        echo json_encode($services);
    }

    public static function save(){
        //Almacena la cita y devuelve el id
        $appointment = new Appointment($_POST);
        $resultado = $appointment->guardar();

        //Almacena las citas y servicios
        $idServicios = explode(',',$_POST['servicios']);
        foreach ($idServicios as $idServicio){
            $args = [
                'appointmentId' => $resultado['id'],
                'serviceId' => $idServicio
            ];

            $appservice = new AppointmentsServices($args);
            $appservice->guardar();
        }

        //Retornamos un resultado
        $respuesta = [
            'resultado' => $resultado
        ];
        
        echo json_encode($respuesta);
    }

    public static function delete (){
        if ($_SERVER['REQUEST_METHOD']=== 'POST'){
            $id = $_POST['id'];

            $appointment = Appointment::find($id);
            $appointment->eliminar();

            header('Location: '. $_SERVER['HTTP_REFERER']);
            
        }
    }
}