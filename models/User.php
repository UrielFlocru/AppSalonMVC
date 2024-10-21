<?php

namespace Model;

class User extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'name', 'lastname', 'email', 'password', 'phone', 'admin', 'confirm', 'token'];

    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $phone;
    public $admin;
    public $confirm;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirm = $args['confirm'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    public function validate (){
        if (!$this->name){  
            self::$alerts['error'][]= "El nombre es obligatorio";
        }
        if (!$this->lastname){  
            self::$alerts['error'][]= "El apellido es obligatorio";
        }
        if (!preg_match('/[0-9]{10}/', $this->phone)){
            self::$alerts['error'][]= "Número de telefono invalido";
        }
        if (!$this->email){  
            self::$alerts['error'][]= "El correo electrónico es obligatorio";
        }
        if (!$this->password){  
            self::$alerts['error'][]= "La contraseña es obligatoria";
        }
        if (strlen($this->password) < 6){
            self::$alerts['error'][] = "La contraseña debe contener al menos 6 caracteres";
        }
        
        return self::$alerts;
    }

    public function validateUser (){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '". $this->email ."' LIMIT 1";

        $resultado = self::$db->query($query);
        
        if ($resultado->num_rows){
            self::$alerts['error'][] = "El usuario ya se encuentra registrado";
        }
        return $resultado;
    }

    public function validateLogin(){
        if (!$this->email){
            self::$alerts['error'][] = "El email es obligatorio";
        }
        if (!$this->password){
            self::$alerts['error'][] = "La contraseña es obligatoria";
        }
        return self::$alerts;
    }

    public function validatePass (){
        if (!$this->password){
            self::$alerts['error'][] = "La contraseña es obligatoria";
        }
        if (strlen($this->password<6)){
            self::$alerts['error'][] = "La contraseña debe tener al menos 6 caracteres";
        }
        return self::$alerts;
    }

    public function validateEmail(){
        if (!$this->email){
            self::$alerts['error'][] = "El email es obligatorio";
        }
        return self::$alerts;
    }

    public function hashPass (){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function genToken(){
        $this->token= uniqid();
    }

    public function checkPassAndVerification ($password){
        $result = password_verify($password, $this->password);

        if (!$this->confirm){
            self::$alerts['error'][] = "Tu cuenta aún no ha sido confirmada";
        }elseif (!$result){
            self::$alerts['error'][] = "Contraseña incorrecta";
        }
        else{
            return true;
        }

    }

}
