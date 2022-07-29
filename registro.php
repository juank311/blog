<?php include("includes/header_front.php") ?>

<?php 

//primero es instanciar la conexion con la base de datos 
$dataBase = new classConnection_mysql;
$db = $dataBase->connection();

//segundo es instacial el objeto que mostrará los insertados

if (isset($_POST['registrarse'])) 
{   $classUsers = new classUsers($db);
    $email = $_POST['email'];
    $classUsers->search_email($email);
    $name = $_POST['name'];
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm_password']);
    $rol_id = $_POST["rol_id"];
    
    if ($classUsers->email_exist == false) 
    {   
        $insert = $classUsers->insert($name, $email, $password, $confirm_password, $rol_id);

        if ($insert == true) 
        {
            $mensaje =  'Usuario creado correctamente';
        } else {
            $error = "No se pudo crear el usuario";
        }
    }
}


?>

    <div class="container-fluid">
        <h1 class="text-center">Registro de Usuarios</h1>
        <div class="row">
            <div class="col-sm-6 offset-3">
                <div class="card">
                   <div class="card-header">
                        Regístrate para poder comentar
                   </div>
                   <?php if (isset($mensaje)) : ?>
                    <!-- mensaje --> 
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo $mensaje;?></strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif ?>
                    <!-- error --> 
                    <?php if (isset($classUsers->error)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?php echo $classUsers->error; ?></strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif ?>
                    <?php if (isset($error)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?php echo $error; ?></strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif ?>
                    <div class="card-body">
                    <form method="POST" action="">

                    <input type="hidden" name="rol_id" value="1">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" name="name" placeholder="Ingresa el nombre">               
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Ingresa el email">               
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Ingresa el password">               
                    </div>

                    <div class="mb-3">
                        <label for="confirmarPassword" class="form-label">Confirmar password:</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Ingresa la confirmación del password">            
                    </div>                    

                    <br />
                    <button type="submit" name="registrarse" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Registrarse</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>  
         
    </div>
<?php include("includes/footer.php") ?>
       