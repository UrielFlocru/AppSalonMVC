<?php

namespace Controllers;

use Model\AdminAppointment;
use MVC\Router;
class AdminController {
    public static function index (Router $router) {
        session_start();

        isAdmin();

        $date= $_GET['fecha'] ?? date('Y-m-d');
        $dates = explode('-',$date);

        if (!checkdate($dates[1],$dates[2],$dates[0])){
            header('Location: /404');
        }

        //Consultar base de datos
        $consulta =  "SELECT appointments.id, appointments.hour, CONCAT( users.name, ' ', users.lastname) as client, ";
        $consulta .= " users.email, users.phone, services.servicename as service, services.price  ";
        $consulta .= " FROM appointments  ";
        $consulta .= " LEFT OUTER JOIN users ";
        $consulta .= " ON appointments.userId=users.id  ";
        $consulta .= " LEFT OUTER JOIN servicesappointments ";
        $consulta .= " ON servicesappointments.appointmentId=appointments.id ";
        $consulta .= " LEFT OUTER JOIN services ";
        $consulta .= " ON services.id=servicesappointments.serviceId ";
        $consulta .= " WHERE date =  '{$date}' ";

        $appointments = AdminAppointment::SQL($consulta);

        $router->render('admin/index',[
            'name' => $_SESSION['name'],
            'appointments' => $appointments,
            'date' => $date
        ]);

    }
}