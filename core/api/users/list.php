<?php
require_once '../../app/sessionObj.php';
$SESSION = new SessionObj();
$MYSQL = new Mysql();

if(isset($_POST["T"])){
    if($_POST["T"] == CYTECHNTOKEN && $SESSION->isLogged){
        if(array_key_exists($SESSION->role_user, MIN_ROLE_1)){
            $result = $MYSQL->select("SELECT u.*, r.name_rol FROM users u INNER JOIN rols r ON u.id_rol_fk = r.id_rol where r.id_casino_fk = " . $SESSION->id_casino);
            $data = "{ \"data\": [";
            $cont = 0;
            while($rows = $result->fetch_assoc()){
                if($cont > 0){
                    $data .= ",";
                }
                $data .= "[";
                $data .= "\"<strong>".$rows["name_user"]."</strong>\"";
                $data .= ",\"".$rows["last_name_user"]."\"";
                $data .= ",\"".$rows["email_user"]."\"";
                $data .= ",\"".$rows["phone_user"]."\"";
                $data .= ",\"".$rows["name_rol"]."\"";
                $estado = $rows["status_user"] == 1 ? "<span class='badge badge-success'>Activo</span>" : "<span class='badge badge-danger'>Inactivo</span>";
                $data .= ",\"".$estado."\"";
                $data .= ",\"<a href='javascript:void(0)' class='btn btn-primary btn-xs' onclick='modalDinamico(\\\"core/api/users/editUsuarioInfo.php\\\", \\\"".$rows["id_user"]."\\\", \\\"Editando usuario...\\\")'><i class='fa fa-pencil'></i>"
                            ."</a> <a href='#' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></a>\"";
                $data .= "]";
                $cont++;
            }
            $data .= "]}";
            echo $data;
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