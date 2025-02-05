<?php
require_once "Mysql.php";

class sessionObj{
    protected Mysql $mysql; // objeto de conexion a base de datos
    public bool $isLogged = false; // sesion activa o usuario logeado

    protected string $token_session = ""; // token de sesion
    public string $name_user = ""; // nombre de usuario
    public string $lastname_user = ""; // apellido de usuario
    public string $image_user = ""; // imagen de usuario
    public string $email_user = ""; // email de usuario
    public string $role_user = ""; // rol de usuario
    public string $id_casino = ""; // id de casino
    public array $permissions = []; // permisos de usuario
    protected int $id_role = 0; // id de rol de usuario
    protected int $id_user = 0; // id de usuario
    protected int $id_session = 0; // id de sesion


    public function __construct(){
        $this->mysql = new Mysql();
        $this->logged();
    }

    /**
     * funcion para verificar si existe una funcion actica en la base de datos que coincida con el token de sesion de la cookie, si existe se asignan los valores a las variables de la clase
     *
     * @return boolean|null
     */
    public function logged(): bool {
        if(isset($_COOKIE[COOKIE_NAME])){
            $token = $_COOKIE[COOKIE_NAME];
            $tokenscope = $this->mysql->escapeString($token);
            $query = "SELECT * FROM sessions s inner join users u on u.id_user = s.id_user_fk inner join rols r on r.id_rol = u.id_rol_fk WHERE token_session = '$tokenscope' AND status_session = 1";
            $result = $this->mysql->select($query);
            if($result){
                if($this->mysql->numRows() > 0){
                    $row = $result->fetch_assoc();
                    $this->id_user = $row['id_user'];
                    $this->id_role = $row['id_rol_fk'];
                    $this->name_user = $row['name_user'];
                    $this->lastname_user = $row['last_name_user'];
                    $this->image_user = $row['image_user'];
                    $this->email_user = $row['email_user'];
                    $this->role_user = $row['name_rol'];
                    $this->token_session = $row['token_session'];
                    $this->id_session = $row['id_session'];
                    $this->id_casino = $row['id_casino_fk'];
                    $this->isLogged = true;
                    $this->mysql->nextResult();
                    $query = "UPDATE sessions SET updated_at = NOW() WHERE (`id_session` = ".$row["id_session"].");";
                    $permisos = $this->mysql->select("SELECT p.name_permission FROM permissions p INNER JOIN permissions_rols pr on p.id_permission = pr.id_permission_fk where pr.id_rol_fk = ".$this->id_role);
                    $this->permissions = array_map(function($item) { 
                        return $item[0];
                    }, $permisos->fetch_all());
                    $this->mysql->query($query);
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            $this->mysql->nextResult();
        }else{
            return false;
        }
    }

    /**
     * funcion para crear una huella digital del dispositivo del usuario y en base a esto crear un token de sesion
     * 
     * @param string $email
     * @param string $password
     * @return string
     */
    public function createToken(string $email, string $password): string{
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $token = hash("sha256", $email.$password.$ip.$user_agent.time());
        $token = openssl_encrypt($token, METHOD_ENCRIPT, KEY_ENCRIPT, 0, IV_ENCRIPT);
        return $token;
    }

    /**
     * funcion para crear una sesion en la base de datos y asignar una cookie al usuario
     * 
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function login(string $email, string $password): bool{
        $emailscope = $this->mysql->escapeString($email);
        $passwordscope = $this->mysql->escapeString($password);
        $query = "SELECT * FROM users u inner join rols r on r.id_rol = u.id_rol_fk WHERE email_user = '$emailscope' AND password_user = '$passwordscope'";
        $result = $this->mysql->select($query);
        if($result){
            if($this->mysql->numRows() > 0){
                $row = $result->fetch_assoc();
                $this->id_user = $row['id_user'];
                $this->id_role = $row['id_rol_fk'];
                $this->name_user = $row['name_user'];
                $this->email_user = $row['email_user'];
                $this->role_user = $row['name_rol'];
                $this->token_session = $this->createToken($email, $password);
                $this->id_session = $this->mysql->query("INSERT INTO sessions (id_user_fk, token_session, status_session) VALUES ($this->id_user, '$this->token_session', 1)");
                if($this->id_session){
                    setcookie(COOKIE_NAME, $this->token_session, [
                        'expires' => time() + COOKIE_TIME,
                        'path' => '/',
                        'secure' => false, // Asegúrate de que la cookie solo se envíe a través de HTTP / agregar true si es HTTPS o tienes un certificado SSL
                        'httponly' => true, // La cookie solo es accesible a través del protocolo HTTP
                        'samesite' => 'strict' // Puedes cambiar a 'lax' o 'None' según tus necesidades
                    ]);
                    return true;
                }else{
                    echo $this->mysql->error;
                    echo $this->mysql->errorControlate;
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
        $this->mysql->nextResult();
    }
}
?>