<?php
require_once '../core/app/Block.php';
$block = new block();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <?php $block->htmlheader("Lista de usuarios"); ?>
    </head>
    <body>
        <!-- partial:partials/_navbar.html -->
        <?php $block->htmlNavBars(); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php $block->htmlNavigationBar(); ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <i class="fa-solid fa-layer-group fa-lg" style="color: #234599"></i>
                            <span> Lista de usuarios del sistema </span>
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>Informacion general de usuarios <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Usuarios registrados en el sistema</h4>
                                    <p class="card-description"> Listado de usuarios registrados en el sistema </p>
                                    <div class="card-header">
                                        <div id="tablausuarioslistButtons" class="align-content-center"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped datatableCytechn" id="tablausuarioslist" data-link="core/api/users/list.php">
                                            <thead>
                                                <tr>
                                                    <th> Nombre </th>
                                                    <th> Apellido </th>
                                                    <th> Correo </th>
                                                    <th> Telefono </th>
                                                    <th> Rol </th>
                                                    <th> Estado </th>
                                                    <th> Acciones </th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 Cyetchnologies &reg; Todos los derechos reservados</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">conectando ideas, inovando el futuro</span>
                </div>
            </footer>
            <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
    
    <?php $block->htmlfooterlinks(); ?>
    </body>
</html>