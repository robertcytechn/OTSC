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
            $rows = $result->fetch_assoc();
            // creamos un formulario con los datos del usuario a editar
            echo '<form id="formEditUser" method="post" action="core/api/users/updateUsuario.php" class="form-normal">
                    <input type="hidden" name="id" value="'.$rows["id_user"].'">
                    <p class="text-primary">Creado: <strong>'.$rows["created_at"].'</strong>, Ultima actualizacion: <strong>'.$rows["updated_at"].'</strong></p>
                    <div class="form-group">
                        <label for="name_user">Nombre</label>
                        <input type="text" class="form-control" id="name_user" name="name_user" value="'.$rows["name_user"].'" required placeholder="Nombre de usuario">
                    </div>
                    <div class="form-group">
                        <label for="last_name_user">Apellido</label>
                        <input type="text" class="form-control" id="last_name_user" name="last_name_user" value="'.$rows["last_name_user"].'" required placeholder="Apellido de usuario">
                    </div>
                    <div class="form-group">
                        <label for="address_user">direccion</label>
                        <input type="text" class="form-control" id="address_user" name="address_user" value="'.$rows["address_user"].'" required placeholder="Direccion de usuario">
                    <div class="form-group">
                        <label for="email_user">Email</label>
                        <input type="email" class="form-control" id="email_user" name="email_user" value="'.$rows["email_user"].'" required placeholder="Email de usuario">
                    </div>
                    <div class="form-group">
                        <label for="phone_user">Telefono</label>
                        <input type="text" class="form-control" id="phone_user" name="phone_user" value="'.$rows["phone_user"].'" required placeholder="Telefono de usuario">
                    </div>
                    <div class="form-group">
                        <label for="id_rol_fk">Rol</label>
                        <select class="form-select" id="id_rol_fk" name="id_rol_fk" required>';
                        // realizamos la consulta para obtener los roles
                        $result = $MYSQL->select("SELECT * FROM rols WHERE id_casino_fk = ".$SESSION->id_casino);
                        while($rows = $result->fetch_assoc()){
                            echo '<option value="'.$rows["id_rol"].'">'.$rows["name_rol"].'</option>';
                        }
                        echo '</select>
                    </div>
                    <div class="form-group">
                        <label for="status_user">Estado</label>
                        <select class="form-select" id="status_user" name="status_user" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password_user">Contraseña</label>
                        <input type="text" class="form-control" id="password_user" name="password_user" placeholder="Contraseña de usuario (dejar en blanco si no se desea cambiar)" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>';
        }
        else{
            echo '<div class="alert alert-danger">Error en el los datos de registro contacte al administrador de sistema</div>';
            exit();
        }
    }
    else{
        echo '<div class="alert alert-danger">Acceso denegado, no tienes permisos para editar usuarios</div>';
        exit();
    }
}
else{
    echo '<div class="alert alert-danger">Acceso denegado, token no valido</div>';
    exit();
}
?>