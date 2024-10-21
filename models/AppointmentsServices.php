<?php

namespace Model;
use Model\ActiveRecord;

class AppointmentsServices extends ActiveRecord{
    protected static $tabla = 'servicesappointments';
    protected static $columnasDB = ['id', 'appointmentId', 'serviceId'];

    public $id;
    public $appointmentId;
    public $serviceId;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->appointmentId = $args['appointmentId'] ?? null;
        $this->serviceId = $args['serviceId'] ?? null;
    }
}