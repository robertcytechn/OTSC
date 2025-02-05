<?php
require_once "../../app/sessionObj.php";

$session = new sessionObj();

if($_POST["T"] == CYTECHNTOKEN){
    if($session->isLogged){
        echo '{"titulo":"Doble interseccion de sesiones","mensaje":"Ya hay una sesion iniciada, cierra la sesion antes de iniciar otra","tipo":"info", "status": "success", "redirect":"'.ROOT.'"}';
    }else{
        if(isset($_POST['login_username']) && isset($_POST['login_password'])){
            if($session->login($_POST['login_username'], $_POST['login_password'])){
                echo '{"titulo":"Iniciando....","mensaje":"Sesión iniciada correctamente.","tipo":"success", "status": "success", "redirect":"'.ROOT.'"}';
            }else{
                echo '{"titulo":"Datos incorrectos","mensaje":"No se ha podido iniciar sesión, por favor verifique sus datos.","tipo":"warning", "status": "success"}';
            }
        }
        else{
            echo '{"titulo":"Datos no resividos","mensaje":"No hemos encontrado datos enviados, contacte con administrador de sistema.","tipo":"error", "status": "success"}';
        }
    }
}
else{
    ECHO "SOLICITUD NO AUTORIZADA O NO VALIDA PARA ESTA ACCION CONTACTE CON EL ADMINISTRADOR DE SISTEMA";
}
//echo '{"titulo":"","mensaje":"No se ha podido iniciar sesión, por favor verifique sus datos.","tipo":"error", "status": "success"}';
?>