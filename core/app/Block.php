<?php
require_once 'sessionObj.php';

$SESSION = new SessionObj();

//********************   BLOKES DE CODIGO DE INSERTADO  *******************************/



class block {

    /**
     * Constructor de la clase block que verifica si el usuario esta logeado, si no lo esta redirige al login
     */
    public function __construct(){
        global $SESSION;
        if(!$SESSION->isLogged){
            header("Location: ".ROOT."login.cy");
        }
    }

    /**
    * Funcion que imprime el header dinamico de la pagina web con el titulo que se le pase como parametro
    *
    * @param string $tittle
    * @return void
    */
    public function htmlheader(string $tittle){
        echo "<meta charset=\"utf-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
            <title>$tittle</title>
            <meta name=\"description\" content=\"Administra tus maquinas de juego de manera sencilla\">
            <meta name=\"author\" content=\"Cyetchnologies\">
            <meta name=\"keywords\" content=\"admin, maquinas, juego, casino, cyetchnologies\">
            <meta name=\"robots\" content=\"index, follow\">
            <meta name=\"googlebot\" content=\"index, follow\">
            <meta name=\"bingbot\" content=\"index, follow\">
            <meta name=\"msnbot\" content=\"index, follow\">
            <link rel=\"stylesheet\" href=\"".ROOT."purple/assets/vendors/mdi/css/materialdesignicons.min.css\">
            <link rel=\"stylesheet\" href=\"".ROOT."purple/assets/vendors/ti-icons/css/themify-icons.css\">
            <link rel=\"stylesheet\" href=\"".ROOT."purple/assets/vendors/css/vendor.bundle.base.css\">
            <link rel=\"stylesheet\" href=\"".ROOT."purple/assets/vendors/font-awesome/css/font-awesome.min.css\">
            <link rel=\"stylesheet\" href=\"".ROOT."core/vendors/FontAwesome/css/all.min.css\">
            <link rel=\"stylesheet\" href=\"".ROOT."core/vendors/dataTables/datatables.css\">
            <link rel=\"stylesheet\" href=\"".ROOT."purple/assets/css/style.css\">
            <link rel=\"shortcut icon\" href=\"".ROOT."core/images/logocasino.png\" />";
    }

    public function htmlfooterlinks(){
        echo "<script src=\"".ROOT."purple/assets/vendors/js/vendor.bundle.base.js\"></script>
            <script src=\"".ROOT."purple/assets/vendors/chart.js/chart.umd.js\"></script>
            <script src=\"".ROOT."core/vendors/FontAwesome/js/all.min.js\"></script>
            <script src=\"".ROOT."purple/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js\"></script>
            <script src=\"".ROOT."purple/assets/js/off-canvas.js\"></script>
            <script src=\"".ROOT."purple/assets/js/misc.js\"></script>
            <script src=\"".ROOT."purple/assets/js/settings.js\"></script>
            <script src=\"".ROOT."purple/assets/js/todolist.js\"></script>
            <script src=\"".ROOT."purple/assets/js/jquery.cookie.js\"></script>
            <script src=\"".ROOT."core/vendors/dataTables/datatables.js\"></script>
            <script src=\"".ROOT."core/app/cytechnHerramientas.js\"></script>
            <script>
                //cuando la pagina este lista
                $(document).ready(function(){
                    new cyetchnHerramientas();
                });
            </script>";
    }

    public function htmlNavBars(){
        global $SESSION;
        $str = "<nav class=\"navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row\">
                    <div class=\"text-center navbar-brand-wrapper d-flex align-items-center justify-content-start\">
                        <a class=\"navbar-brand brand-logo\" href=\"index.html\"><img src=\"".ROOT."core/images/logolargoiot.png\" alt=\"logo\" /></a>
                        <a class=\"navbar-brand brand-logo-mini\" href=\"index.html\"><img src=\"".ROOT."core/images/logominiiot.png\" alt=\"logo\" /></a>
                    </div>
                    <div class=\"navbar-menu-wrapper d-flex align-items-stretch\">
                        <button class=\"navbar-toggler navbar-toggler align-self-center\" type=\"button\" data-toggle=\"minimize\">
                            <span class=\"mdi mdi-menu\"></span>
                        </button>";

        
        
        //FIXME Cy Warning: This is a temporal solution, the search bar is not implemented yet
        $str .= "<div class=\"search-field d-none d-md-block\">
                    <form class=\"d-flex align-items-center h-100\" action=\"#\">
                        <div class=\"input-group\">
                            <div class=\"input-group-prepend bg-transparent\">
                                <i class=\"input-group-text border-0 mdi mdi-magnify\"></i>
                            </div>
                            <input type=\"text\" class=\"form-control bg-transparent border-0\" placeholder=\"Proximamente...\" disabled>
                        </div>
                    </form>
                </div>";


        
        
                //NOTE Cy: This is the user profile dropdown menu, if no image is provided, the default image is used
        $image_tmp = "";
        $image_tmp = $SESSION->image_user != "noimage" ? ROOT."core/images/users/".$SESSION->name_user.$SESSION->lastname_user."/".$SESSION->image_user : ROOT."core/images/noImage.svg";
        // menu de usuario logeado como actividad logs y cerrar sesion y tambien el boton de pantalla completa
        $str .= "<ul class=\"navbar-nav navbar-nav-right\">
                    <li class=\"nav-item nav-profile dropdown\">
                        <a class=\"nav-link dropdown-toggle\" id=\"profileDropdown\" href=\"#\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                            <div class=\"nav-profile-img\">
                            <img src=\"".$image_tmp."\" alt=\"image\">
                            <span class=\"availability-status online\"></span>
                            </div>
                            <div class=\"nav-profile-text\">
                            <p class=\"mb-1 text-black\">".$SESSION->name_user." ".$SESSION->lastname_user."</p>
                            </div>
                        </a>
                        <div class=\"dropdown-menu navbar-dropdown\" aria-labelledby=\"profileDropdown\">
                            <a class=\"dropdown-item\" href=\"".ROOT."core/app/logs.cy\">
                                <i class=\"mdi mdi-cached me-2 text-success\"></i> Tu Actividad (log) </a>
                                <div class=\"dropdown-divider\"></div>
                            <a class=\"dropdown-item\" href=\"#\" id=\"logoutbutton\"><i class=\"mdi mdi-logout me-2 text-primary\"></i> Cerrar Sesion </a>
                        </div>
                    </li>
                    <li class=\"nav-item d-none d-lg-block full-screen-link\">
                        <a class=\"nav-link\">
                            <i class=\"mdi mdi-fullscreen\" id=\"fullscreen-button\"></i>
                        </a>
        </li>";

        //FIXME Cy Warning: This is a temporal solution, the menssages bar is not implemented yet
        $str .= "<li class=\"nav-item dropdown\">
                <a class=\"nav-link count-indicator dropdown-toggle\" id=\"messageDropdown\" href=\"#\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                    <i class=\"mdi mdi-email-outline\"></i>
                    <span class=\"count-symbol bg-warning\"></span>
                </a>
                <div class=\"dropdown-menu dropdown-menu-end navbar-dropdown preview-list\" aria-labelledby=\"messageDropdown\">
                    <h6 class=\"p-3 mb-0\">Mensajes</h6>
                    <div class=\"dropdown-divider\"></div>
                    <a class=\"dropdown-item preview-item\">
                        <div class=\"preview-thumbnail\">
                            <img src=\"".ROOT."core/images/logocasino.png\" alt=\"image\" class=\"profile-pic\">
                        </div>
                        <div class=\"preview-item-content d-flex align-items-start flex-column justify-content-center\">
                            <h6 class=\"preview-subject ellipsis mb-1 font-weight-normal\">Proximamente....</h6>
                            <p class=\"text-gray mb-0\"> [En desarrollo..] </p>
                        </div>
                    </a>
                <div class=\"dropdown-divider\"></div>
                <h6 class=\"p-3 mb-0 text-center\">No hay mensajes nuevos</h6>
                </div>
        </li>";


        //FIXME Cy Warning: This is a temporal solution, the notifications bar is not implemented yet
        $str .= "<li class=\"nav-item dropdown\">
                        <a class=\"nav-link count-indicator dropdown-toggle\" id=\"notificationDropdown\" href=\"#\" data-bs-toggle=\"dropdown\">
                            <i class=\"mdi mdi-bell-outline\"></i>
                            <span class=\"count-symbol bg-danger\"></span>
                        </a>
                        <div class=\"dropdown-menu dropdown-menu-end navbar-dropdown preview-list\" aria-labelledby=\"notificationDropdown\">
                            <h6 class=\"p-3 mb-0\">Notificaciones</h6>
                            <div class=\"dropdown-divider\"></div>
                            <a class=\"dropdown-item preview-item\">
                                <div class=\"preview-thumbnail\">
                                    <div class=\"preview-icon bg-info\">
                                        <i class=\"mdi mdi-link-variant\"></i>
                                    </div>
                                </div>
                                <div class=\"preview-item-content d-flex align-items-start flex-column justify-content-center\">
                                    <h6 class=\"preview-subject font-weight-normal mb-1\">Proximamente....</h6>
                                    <p class=\"text-gray ellipsis mb-0\"> [En desarrollo..]</p>
                                </div>
                            </a>
                            <div class=\"dropdown-divider\"></div>
                            <h6 class=\"p-3 mb-0 text-center\">No hay notificaciones</h6>
                        </div>
        </li>";

        $str .= "</ul>
            <button class=\"navbar-toggler navbar-toggler-right d-lg-none align-self-center\" type=\"button\" data-toggle=\"offcanvas\">
                <span class=\"mdi mdi-menu\"></span>
            </button>
            </div>
        </nav>";

        echo $str;
    }


    public function htmlNavigationBar(){
        global $SESSION;
        $image_tmp = "";
        $image_tmp = $SESSION->image_user != "noimage" ? ROOT."core/images/users/".$SESSION->name_user.$SESSION->lastname_user."/".$SESSION->image_user : ROOT."core/images/noImage.svg";
        $str = "<nav class=\"sidebar sidebar-offcanvas\" id=\"sidebar\">
                    <ul class=\"nav\">
                        <li class=\"nav-item nav-profile\">
                        <a href=\"#\" class=\"nav-link\">
                            <div class=\"nav-profile-image\">
                            <img src=\"".$image_tmp."\" alt=\"profile\" />
                            </div>
                            <div class=\"nav-profile-text d-flex flex-column\">
                                <span class=\"font-weight-bold mb-2\">".$SESSION->name_user." ".$SESSION->lastname_user."</span>
                                <span class=\"text-secondary text-small\">".$SESSION->role_user."</span>
                            </div>
                            <i class=\"mdi mdi-bookmark-check text-success nav-profile-badge\"></i>
                        </a>
        </li>";

        //NOTE Cy: verificar si agregar mas roles o menos los roles deben de ser estaticos para evitar errores
        $menus = json_decode(file_get_contents(ROOT."core/app/NavigatorMenus.json"));
        //colocaremos una funcion que recorra el json y genere los menus de manera dinamica en base al rol del usuario y verificamos si tiene hijos para generar los submenus
        foreach($menus as $menu){
            if(in_array($SESSION->role_user, $menu->rol)){
                //verificamos si tiene hijos
                if(count($menu->childs) > 0){
                    $str .= "<li class=\"nav-item\">
                                <a class=\"nav-link\" data-bs-toggle=\"collapse\" href=\"#$menu->ident\" aria-expanded=\"false\" aria-controls=\"$menu->ident\">
                                    <span class=\"menu-title\">$menu->tittle &MediumSpace;</span>&MediumSpace;
                                    <i class=\"$menu->icon\" style=\"color:$menu->color;\"></i>
                                    <i class=\"menu-arrow\"></i>
                                </a>
                            <div class=\"collapse\" id=\"$menu->ident\">
                    <ul class=\"nav flex-column sub-menu\">";
                    foreach($menu->childs as $child){
                        $str .= "<li class=\"nav-item\">
                                    <a class=\"nav-link\" href=\"".ROOT.$child->link."\">$child->tittle</a>
                                </li>";
                    }
                    $str .= "</ul>
                            </div>
                        </li>";
                }
                else{
                    $str .= "<li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"".ROOT.$menu->link."\">
                            <span class=\"menu-title\">$menu->tittle &MediumSpace;</span>&MediumSpace;
                            <i class=\"$menu->icon\" style=\"color:$menu->color;\"></i>
                        </a>
                    </li>";
                }
            }
        }

        $str .= "</ul>
            </nav>";
        echo $str;
    }

}
?>