<?php
require_once '../../app/sessionObj.php';
$SESSION = new SessionObj();

if(isset($_POST["T"])){
    if($_POST["T"] == CYTECHNTOKEN && $SESSION->isLogged){
        if(array_key_exists($SESSION->role_user, MIN_ROLE_1)){
        }
    } 
    else{
        echo '{"data":[["Acceso no autorizado sesion o token no validos."]]}';
        exit();
    }
}
else{
    echo '{"data":[["Acceso denegado token no valido."]]}';
    exit();
}


//revisamos si el post T esta definidio y el igual a TOKEN
//if(isset($_POST['T']) && $_POST['T'] == CYTECHNTOKEN && $SESSION->isLogged){ // Si el token es correcto y el usuario esta logueado
//    echo '{"data":[["No tienes permisos para acceder a este recurso."]]}';
//}
//else{
//    echo '{"data":[["No tienes permisos para acceder a este recurso."]]}';
//    exit();
//}
?>