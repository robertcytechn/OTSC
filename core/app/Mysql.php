<?php
require_once 'conf.php';

class Mysql{
    protected bool $open = false;
    protected mysqli $conexion;
    protected ?mysqli_result $result;
    protected ?string $query;
    public ?string $error;
    public ?string $errorControlate;

    public function __construct(){
        try {
            $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($this->conexion->connect_error){
                $this->error = $this->conexion->connect_error;
                $this->errorControlate = ERR_CONN;
                $this->open = false;
            }else{
                $this->open = true;
            }
        } catch (\Exception $th) {
            $this->error = $th;
            $this->errorControlate = ERR_CONN;
            $this->open = false;
        }
    }

    /**
     * Método para cerrar la conexión a la base de datos.
     */
    public function closeConnection(): void {
        if ($this->open) {
            $this->conexion->close();
            $this->open = false;
        }
    }

    /**
     * Método para obtener el número de filas afectadas por la última consulta.
     *
     * @return int
     */
    public function affectedRows(): int {
        if ($this->open) {
            return $this->conexion->affected_rows;
        }
        return 0;
    }


    /**
     * Método para obtener el último ID insertado.
     *
     * @return int
     */
    public function lastInsertId(): int {
        if ($this->open) {
            return $this->conexion->insert_id;
        }
        return 0;
    }

    /**
     * Método para manejar errores y registrar en logs.
     *
     * @param \Exception $th
     * @param string $customError
     */
    private function handleError(\Exception $th, string $customError): void {
        $this->error = $th->getMessage();
        $this->errorControlate = $customError;
        // Aquí puedes agregar código para registrar el error en un log.
    }

    /**
     * Funcion que retorna un string con la hora minuto y segundo actual en formato mysql
     *
     * @return string
     */
    public function timeMysql(){
        return date('Y-m-d H:i:s');
    }

    /**
     * Funcion que retorna un string con la fecha actual en formato mysql
     *
     * @return string
     */
    public function dateMysql(){
        return date('Y-m-d');
    }

    /**
     * funcion que prepara al objeto para ajecutar una  ueva consulta de tipo select, retorna un booleano si se ejecuto correctamente
     *
     * @return boolean
     */
    public function nextResult():bool{
        if($this->open){
            try {
                mysqli_next_result($this->conexion);
                $this->error = null;
                $this->errorControlate = null;
                return true;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_NEXTR);
                return false;
            }
        }
        else return false;
    }

    /**
     * Funcionq ue inicia una transaccion en la base de datos y retorna un booleano si se ejecuto correctamente
     *
     * @return boolean
     */
    public function beginTransaction():bool{
        if($this->open){
            try {
                $this->conexion->begin_transaction();
                $this->error = null;
                $this->errorControlate = null;
                return true;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_BEGINTRANSACTION);
                return false;
            }
        }
        else return false;
    }

    /**
     * Funcion que confirma una transaccion en la base de datos y retorna un booleano si se ejecuto correctamente
     *
     * @return boolean
     */
    public function commitTransaction():bool{
        if($this->open){
            try {
                $this->conexion->commit();
                $this->error = null;
                $this->errorControlate = null;
                return true;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_COMMITTRANSACTION);
                return false;
            }
        }
        else return false;
    }

    /**
     * Funcion que cancela una transaccion en la base de datos y retorna un booleano si se ejecuto correctamente
     *
     * @return boolean
     */
    public function rollbackTransaction():bool{
        if($this->open){
            try {
                $this->conexion->rollback();
                $this->error = null;
                $this->errorControlate = null;
                return true;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_ROLLBACKTRANSACTION);
                return false;
            }
        }
        else return false;
    }

    /**
     * function que ejecuta una consulta de tipo select y retorna un objeto con los datos obtenidos de la base de datos o un booleano si ocurrio un error
     *
     * @param string $query
     * @return mysqli_result|boolean
     */
    public function select($query): mysqli_result|bool {
        if($this->open){
            try {
                $resulttmp = $this->conexion->query($query);
                $this->result = $resulttmp;
                $this->error = null;
                $this->errorControlate = null;
                return $resulttmp;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_SELECT);
                return false;
            }
        }
        else return false;
    }

    /**
     * funcion que ejecuta una consulta de tipo insert, update o delete y retorna un booleano si se ejecuto correctamente
     *
     * @param string $query
     * @return boolean
     */
    public function query($query):bool{
        if($this->open){
            try {
                $resulttmp = $this->conexion->query($query);
                $this->error = null;
                $this->errorControlate = null;
                return true;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_QUERY);
                return false;
            }
        }
        else return false;
    }

    /**
     * funcion que retorna un array asociativo con los datos obtenidos de la base de datos
     * 
     * @return array|bool
     */
    public function assoc():array|bool{
        if($this->open){
            try {
                $resulttmp = $this->result->fetch_assoc();
                $this->error = null;
                $this->errorControlate = null;
                return $resulttmp;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_FETCH);
                return false;
            }
        }
        else return false;
    }

    /**
     * funcion que retorna un array indexado con los datos obtenidos de la base de datos
     *
     * @return array|bool
     */
    public function row():array|bool{
        if($this->open){
            try {
                $resulttmp = $this->result->fetch_row();
                $this->error = null;
                $this->errorControlate = null;
                return $resulttmp;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_FETCH);
                return false;
            }
        }
        else return false;
    }

    /**
     * Método para escapar cadenas y prevenir inyecciones SQL.
     *
     * @param string $string
     * @return string
     */
    public function escapeString(string $string): string {
        if ($this->open) {
            return $this->conexion->real_escape_string($string);
        }
        return $string;
    }

    /**
     * Método para obtener el número de filas en el resultado de una consulta.
     *
     * @return int
     */
    public function numRows(): int {
        if ($this->open && $this->result) {
            return $this->result->num_rows;
        }
        return 0;
    }

    /**
     * Método para obtener todos los resultados de una consulta en un array.
     *
     * @return array|bool
     */
    public function fetchAll(): array|bool {
        if ($this->open && $this->result) {
            try {
                $resultArray = $this->result->fetch_all(MYSQLI_ASSOC);
                $this->error = null;
                $this->errorControlate = null;
                return $resultArray;
            } catch (\Exception $th) {
                $this->handleError($th, ERR_FETCH);
                return false;
            }
        }
        return false;
    }

}
?>