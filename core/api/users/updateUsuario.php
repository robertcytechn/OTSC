<?php
require_once '../../app/sessionObj.php';
$SESSION = new SessionObj();
$MYSQL = new Mysql();

// updateamos los datos del usuario en la base de datos con los datos enviados por el formulario
if(isset($_POST["T"]) && $_POST["T"] == CYTECHNTOKEN && $SESSION->isLogged){
    if(in_array("Editar usuarios", $SESSION->permissions)){
        //UPDATE `casino_test`.`users` SET `id_rol_fk` = 'rol', `name_user` = 'nom', `last_name_user` = 'lat', `email_user` = 'ema', 
        //`password_user` = 'pass', `phone_user` = 'phone', `address_user` = 'addres', `status_user` = 'est' WHERE (`id_user` = '1');

        $query = "UPDATE users SET id_rol_fk = '".$_POST["id_rol_fk"]."', name_user = '".$_POST["name_user"]."', last_name_user = '"
        .$_POST["last_name_user"]."', email_user = '".$_POST["email_user"]."', phone_user = '".$_POST["phone_user"]."', address_user = '"
        .$_POST["address_user"]."', status_user = '".$_POST["status_user"]."'";

        if($_POST["password_user"] != "" && isset($_POST["password_user"])){
            $query .= ", password_user = '".$_POST["password_user"]."'";
        }

        $query .= " WHERE id_user = ".$_POST["id"];

        $result = $MYSQL->query($query);
        if($result){
            echo '{"titulo":"Usuario actualizado","mensaje":"El usuario se ha actualizado correctamente.","tipo":"success", "status": "success", "reload": "true", "modal": "true"}';
        }
        else{
            echo '{"titulo":"Error al actualizar","mensaje":"No se ha podido actualizar el usuario.['.$MYSQL->error.']","tipo":"error", "status": "danger"}';
        }
    }
    else{
        echo '{"titulo":"Acceso no autorizado","mensaje":"No tienes permisos para acceder a este recurso.","tipo":"error", "status": "danger"}';
    }
}
else{
    echo '{"titulo":"Acceso no autorizado","mensaje":"Token no valido imposible proceder.","tipo":"error", "status": "danger"}';
    exit();
}
//echo '{"titulo":"","mensaje":"No se ha podido iniciar sesión, por favor verifique sus datos.","tipo":"error", "status": "success"}';
?>