<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {
    public static function login (Router $router){

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new User($_POST);
            $alerts = $auth->validateLogin();

            if (empty($alerts)){
                //Comprobar que existe el email
                $user = User::where('email',$auth->email);
                if ($user){
                    //Verificar el password
                    if ($user->checkPassAndVerification($auth->password)){
                        //Autenticar el usuario
                        session_start();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name ." " . $user->lastname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento
                        if ($user->admin === "1"){
                            //Admin
                            $_SESSION['admin'] = $user->admin ?? null;
                            header ('Location: /admin');
                        }else{
                            //Client
                            header ('Location: /appointment');
                        }
                        
                        
                    }

                }else{
                    User::setAlert('error', "Usuario no encontrado");
                }
            }
        }
        $alerts= User::getAlerts();
        $router->render('auth/login',[
            'alerts' => $alerts
        ]);
        
    }
    public static function logout (){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function forgot (Router $router){
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new User($_POST);
            $alerts = $auth->validateEmail();

            if (empty($alerts)){
                //Verificar que el email existe
                $user = User::where('email',$auth->email);
                if ($user && $user->confirm === "1"){
                    //El usuario existe y esta confirmado

                    //Generar un nuevo token
                    $user->genToken();
                    $user->guardar();

                    //Enviar email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendInstructions();

                    //Alerta Exito
                    User::setAlert('exito', "Hemos enviado las instrucciones a tu correo electronico");
                }else{
                    //No existe ó no confirmado
                    User::setAlert('error',"El usuario no existe o no esta confirmado");
                    
                }
            }


        }

        $alerts = User::getAlerts();
        $router->render('auth/forgot',[
            'alerts' => $alerts
        ]);
    }
    public static function reset (Router $router){
        $alerts = [];
        $token = s($_GET['token']);
        $error = false;

        //Buscar usuario
        $user = User::where('token', $token);

        if (empty($user)){
            User::setAlert('error',"Token Invalido");
            $error = true;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $password= new User($_POST);
            $alerts = $password->validatePass();

            if (empty($alerts)){
                $user->password = null;
                $user->password = $password->password;
                $user->hashPass();
                $user->token= null;

                $result = $user->guardar();

                if ($result){
                    header('Location: /');
                }
            }
        }


        $alerts = User::getAlerts();
        $router->render('auth/reset',[
            'alerts' => $alerts,
            'error' => $error
        ]);
    }
    public static function register (Router $router){
        $user = new User;
        $alerts = User::getAlerts();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $user->sincronizar($_POST);
            $alerts = $user->validate();

            if (empty($alerts)){

                //Verificar que el usuario no este registrado previamente
                $resultado= $user->validateUser();

                if($resultado->num_rows){
                    $alerts = User::getAlerts();
                }else{
                    //Hashear password
                    $user->hashPass();

                    //Generar token único
                    $user->genToken();

                    //Enviar el email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendConfirmation();

                    //Crear el usuarios
                    $resultado= $user->guardar();

                    if ($resultado){

                        header('Location: /message');
                    }
                }
            }
        }

        $router->render('auth/register',[
            'user' => $user,
            'alerts' =>$alerts
        ]);
    }

    public static function message (Router $router){
        $router->render('auth/message');
    }
    public static function confirm (Router $router){
        $alerts = [];
        $token = s($_GET['token']);

        $user = User::where('token', $token);

        
        if (empty($user)){
            //Mostrar mensaje de error
            User::setAlert('error', 'El token es invalido');

        }else{
            //Modificar al usuario confirmado
           $user->confirm = "1";
           $user->token = null;
           $user->guardar();
           User::setAlert('exito','Cuenta confirmada correctamente');
        }
        
        $alerts = User::getAlerts();
        $router->render('auth/confirm',[
            'alerts' => $alerts
        ]);
    }

}