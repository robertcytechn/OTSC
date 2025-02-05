<?php
require_once 'core/app/Block.php';
$block = new block();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <?php $block->htmlheader("Panel de comandos IOT [INTEGRACIÓN DE OPERACIONES TÉCNICAS]"); ?>
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
                            <span> Panel de comandos, integracion y operaciones tecnicas</span>
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>Informacion general de sala <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Aquí va el contenido de la página -->
                    <div class="row">
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