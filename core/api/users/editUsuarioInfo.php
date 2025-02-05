<?php
require_once '../../app/sessionObj.php';
$SESSION = new SessionObj();
$MYSQL = new Mysql();

// verificamos que el token sea correcto y que el usuario este logueado
if(isset($_POST["T"]) && $_POST["T"] == CYTECHNTOKEN && $SESSION->isLogged){
    // verificamos que el usuario tenga permisos de edicion de usuarios, para esto revisamos el array permissions en sessionObj.php y verificamos que exista editar usuarios
    if(in_array("Editar usuarios", $SESSION->permissions)){
        // verificamos que el id del usuario a editar este definido
        if(isset($_POST["id"])){
            // realizamos la consulta para obtener los datos del usuario a editar
            $result = $MYSQL->select("SELECT * FROM users WHERE id_user = ".$_POST["id"]);
        }
        else{
            echo '<div class="alert alert-danger">Error en el los datos de registro contacte al administrador de sistema</div>';
            exit();
        }
    }
    else{
        echo '<div class="alert alert-danger">Acceso denegado, no tienes permisos para editar usuarios '.var_dump($SESSION->permissions).'</div>';
        exit();
    }
}
else{
    echo '<div class="alert alert-danger">Acceso denegado, token no valido</div>';
    exit();
}
?>