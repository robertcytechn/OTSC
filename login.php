<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Control OT | cyetchn</title>
    <link rel="stylesheet" href="purple/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="purple/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="purple/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="purple/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="purple/assets/css/style.css">
    <link rel="stylesheet" href="core/vendors/sweetalert2.min.css">
    <link rel="shortcut icon" href="core/images/logocasino.png"/>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="core/images/logocasino.png" class="mx-auto d-block">
                </div>
                <h4>Control operaciones tecnicas</h4>
                <h6 class="font-weight-light">Inicia sesion para continuar.</h6>
                <form class="pt-3 form-normal" action="core/api/public/loginC.cy" method="post">
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="login_username" name="login_username" placeholder="Correo electronico" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="login_password" name="login_password" placeholder="Contraseña" required>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">ETRAR</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="core/vendors/jquery-3.7.1.min.js"></script>
    <script src="purple/assets/js/off-canvas.js"></script>
    <script src="purple/assets/js/misc.js"></script>
    <script src="purple/assets/js/settings.js"></script>
    <script src="purple/assets/js/todolist.js"></script>
    <script src="purple/assets/js/jquery.cookie.js"></script>
    <script src="core/vendors/sweetalert.js"></script>
    <script src="core/app/cytechnHerramientas.js"></script>
    <script>
      //cuando la pagina este lista
      $(document).ready(function(){
        new cyetchnHerramientas();
      });
    </script>
  </body>
</html>