<?php

namespace Model;
use Model\ActiveRecord;

class Service extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'services';
    protected static $columnasDB = ['id', 'servicename', 'price'];

    public $id;
    public $servicename;
    public $price;

    public function __construct($args =[]){
        $this->id = $args['id'] ?? null;
        $this->servicename = $args['servicename'] ?? '';
        $this->price = $args['price'] ?? '';
    }

    public function validate (){
        if (!$this->servicename){
            self::$alerts['error'][]= "El nombre del servicio es obligatorio";
        }
        if (!$this->price){
            self::$alerts['error'][]= "El precio del servicio es obligatorio";
        }
        if (!is_numeric($this->price)){
            self::$alerts['error'][]= "El precio no es válido";
        }


        return self::$alerts;
    }

}

