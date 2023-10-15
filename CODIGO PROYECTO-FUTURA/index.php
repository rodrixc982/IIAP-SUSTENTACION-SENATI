

<?php
$alert = '';
session_start();
if (!empty($_SESSION['active'])) {
  header('location: sistema/');
} else {
  if (!empty($_POST)) {
    if (empty($_POST['correo']) || empty($_POST['clave'])) {
      $alert = '<div class="alert alert-danger" role="alert">
  Ingrese su usuario y su clave
</div>';
    } else {
      require_once "conexion.php";
      $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
      $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
      $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, u.telefono, r.idrol, r.rol, u.estado FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.correo = '$correo' AND u.clave = '$clave'");
      mysqli_close($conexion);
      $resultado = mysqli_num_rows($query);
      if ($resultado > 0) {
        $dato = mysqli_fetch_array($query);
        if ($dato['estado'] == 1) {
          $_SESSION['active'] = true;
          $_SESSION['idUser'] = $dato['idusuario'];
          $_SESSION['nombre'] = $dato['nombre'];
          $_SESSION['email'] = $dato['correo'];
          $_SESSION['user'] = $dato['usuario'];
          $_SESSION['tel'] = $dato['telefono'];
          $_SESSION['rol'] = $dato['idrol'];
          $_SESSION['rol_name'] = $dato['rol'];
          if ($dato['idrol'] == 1 || $dato['idrol'] == 2) {
            header('location: sistema/');
          } else {
            header("Location: sistema/productos.php ");
          }
        } else {
          $alert = '<div class="alert alert-danger" role="alert">
                      Usuario Inactivo
                  </div>';
        }
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                     Usuario o Contraseña Incorrecta
                 </div>';
        session_destroy();
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>FUTURA</title>
  
  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="sistema/vendor/bootstrap/css/bootstrap.min.css">


</head>

<body class="bg-gradient-primary">

  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image">
                <img src="sistema/img/OIP.jpg" class="img-thumbnail">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">

                    <h1 class="h4 text-gray-900 mb-4">Inicio de Sesión</h1>
                  </div>
                  <form class="user" method="POST">
                    <?php echo isset($alert) ? $alert : ""; ?>
                    <div class="form-group">
                      <label for="">Usuario</label>
                      <input type="text" class="form-control" placeholder="Correo" name="correo">
                    </div>
                    <div class="form-group">
                      <label for="">Contraseña</label>
                      <input type="password" class="form-control" placeholder="Contraseña" name="clave">
                    </div>
                    <input type="submit" value="Iniciar Sesión" class="btn btn-primary">
                    <a href="../sistema/../index.php"  class="btn btn-primary">Regresar</a>

                    <hr>
                  </form>
                  <a href="sistema/registrarse.php"  style="padding-right: 50px;">Registrarse</a>
                  <a href="sistema/recuperar_pass.php">¿Olvidó su contraseña?</a>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- JavaScript files-->
  <script src="sistema/vendor/jquery/jquery.min.js"></script>
  <script src="sistema/vendor/popper.js/umd/popper.min.js"> </script>
  <script src="sistema/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="sistema/vendor/jquery.cookie/jquery.cookie.js"> </script>
  <script src="sistema/vendor/jquery-validation/jquery.validate.min.js"></script>
  <script src="sistema/js/front.js"></script>


</body>

</html>