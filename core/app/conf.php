<?php

// recordemos que dentro de la carpeta de app se almacenaran todos los archivos de funcionamiento interno de la aplicacion
// y en la carpeta api se almacenaran los archivos de acceso o los cuales retornan informacion a traves de una peticion http


//********************   CONSTANTES DE CONFIGURACION DE BASE DE DATOS   *******************************/

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'casino_test');


//********************   CONSTANTES DE CONFIGURACION DE ERRORES   *******************************/

define('DEBUG', true);

if(DEBUG){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}else{
    error_reporting(0);
    ini_set('display_errors', 0);
}

define('ERR_CONN','Error de conexion a la base de datos');
define('ERR_NEXTR','Error al preparar la siguiente consulta');
define('ERR_QUERY','Error en la ejecucion del query a la base de datos');
define('ERR_SELECT','Error en la seleccion de datos de la base de datos');
define('ERR_FETCH','Error en la obtencion de datos de la base de datos, y convertirlos a un array');
define('ERR_BEGINTRANSACTION','Error en la insercion de datos en la base de datos');
define('ERR_COMMITTRANSACTION','Error en la confirmacion de la transaccion');
define('ERR_ROLLBACKTRANSACTION','Error en la cancelacion de la transaccion');


//********************   CONSTANTES DE CONFIGURACION DE RUTAS   *******************************/

define('ROOT', $_SERVER['HTTP_HOST']=='localhost' ? 'http://'.$_SERVER['HTTP_HOST'].'/casino/OTSC/' : 'http://'.$_SERVER['HTTP_HOST'].'/');
define('APP', ROOT.'core/app/');
define('API', ROOT.'core/api/');
define('COOKIE_NAME','cytechnologies');
define('COOKIE_TIME', 60*60*24*30); // 30 dias

//********************   CONSTANTES DE CONFIGURACION CIFRADO   *******************************/

define('KEY_ENCRIPT','cytechnologiesChido1993$'.date('Y m d H i s A'));
define('METHOD_ENCRIPT','AES-256-CBC');
define('IV_ENCRIPT', '1234567891011121');
define('CYTECHNTOKEN','D4F8FF5E5B6A01C59836CCDDAA45F2C5BA5FA6586A55S4'); //201


//********************   CONSTANTES DE CONFIGURACION ROLES Y PERMISOS   *******************************/
// roles con jerarquia de permisos de acceso igual a 1 genear array con datos del archivo roles.json
$roles = json_decode(file_get_contents(APP.'roles.json'), true);
$roles_1 = array_filter($roles, function($value) {
    return $value <= 1;
});
define('MIN_ROLE_1', $roles_1);
$roles_2 = array_filter($roles, function($value) {
    return $value <= 2;
});
define('MIN_ROLE_2', $roles_2);
$roles_3 = array_filter($roles, function($value) {
    return $value <= 3;
});
define('MIN_ROLE_3', $roles_3);
$roles_4 = array_filter($roles, function($value) {
    return $value <= 4;
});
define('MIN_ROLE_4', $roles_4);
$roles_5 = array_filter($roles, function($value) {
    return $value <= 5;
});
define('MIN_ROLE_5', $roles_5);
$roles_6 = array_filter($roles, function($value) {
    return $value <= 6;
});
define('MIN_ROLE_6', $roles_6);
$roles_7 = array_filter($roles, function($value) {
    return $value <= 7;
});
define('MIN_ROLE_7', $roles_7);

?>
