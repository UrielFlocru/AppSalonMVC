<?php
namespace Model;
use Model\ActiveRecord;

class Appointment extends ActiveRecord {    
    //base de datos
    protected static $tabla = 'appointments';
    protected static $columnasDB = ['id','date','hour','userId'];
    
    public $id;
    public $date;
    public $hour;
    public $userId;

    public function __construct($args =[]){
        $this->id= $args['id'] ?? null;
        $this->date= $args['fecha'] ?? '';
        $this->hour= $args['hora'] ?? '';
        $this->userId= $args['usuarioId'] ?? '';

    }

}