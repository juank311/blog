<?php session_start();
      include('config/config.php');
      include('includes/header.php');
      include('includes/nav.php');
      include('config/connection_mysql.php');
      include('helpers/helper_format.php');
      include('models/users.php');


$dataBase = new classConnection_mysql;
$db = $dataBase->connection();
$classUsers = new classUsers($db);

if (isset($_POST['acceder'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $classUsers->login($email, $password);

    if (isset($classUsers->mensaje)) { 
        
        $_SESSION['activo'] = true;
        header('Location: index.php');
    } else {
        $_SESSION['activo'] = false;
    }
}


?>

<!-- error Alt+Shift+F -->
<?php if (isset($classUsers->error)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $classUsers->error; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

    <div class="container-fluid">
        <h1 class="text-center">Acceso de Usuarios</h1>
        <div class="row">
            <div class="col-sm-6 offset-3">
                <div class="card">
                   <div class="card-header">
                        Ingresa tus datos para acceder, si no tienes cuenta<a href="/blog/registro.php">    registrate aquí</a>
                   </div>
                    <div class="card-body">
                    <form method="POST" action="">

                   

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Ingresa el email">               
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Ingresa el password">               
                    </div>

                    <br />
                    <button type="submit" name="acceder" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Acceder</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>  
         
    </div>
<?php include("includes/footer.php") ?>