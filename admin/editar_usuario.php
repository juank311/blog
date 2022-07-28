<?php include("../includes/header.php");

//primero es instanciar la conexion con la base de datos 
$dataBase = new classConnection_mysql;
    $db = $dataBase->connection();

//Se instancia el objeto que mostrará el resultado 
$classUsers = new classUsers($db);
    $id = $_GET['id'];
    $user = $classUsers->search_one($id);

//Se llama la clase de busqueda global, para analizar si existe la imagen antigua 

    //traer funcion para actualizar
if (isset($_POST['editarUsuario']))
{   
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $rol_id = ($_POST['rol']);
         
    if ($classUsers->update($name, $email, $password, $rol_id, $id)) 
    {
        
        header("Refresh:2");
        header("Location: ".RUTA_ADMIN."usuarios.php");
    } 
    
} 

if (isset($_POST['borrarUsuario']))
{   
    $delete = $classUsers->delete($id);

         
    if ($delete) 
    {   $mensaje = "Usuario eliminado con exito";
        header("Location: ".RUTA_ADMIN."usuarios.php?mensaje=".urlencode($mensaje));
    } 
    
} 

?>

    <div class="row">
        <div class="col-sm-6">
            <h3>Editar Usuario</h3>
        </div> 
                    <?php if (isset($classUsers->mensaje)) : ?>
                    <!-- mensaje --> 
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo $classUsers->mensaje;?></strong> 
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
                              
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="">

            <!-- <input type="hidden" name="id" value=">  Sirve para enviar datos por el metodo POST -->

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="name" id="nombre" placeholder="Ingresa el nombre" value="<?php echo $user->name_user;?>">              
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Ingresa el password" value="<?php echo $user->password;?>">               
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" value="<?php echo $user->email_user;?>">               
            </div>
            <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select class="form-select" aria-label="Default select example" name="rol">
                <option value="">-->Seleccione un rol<--</option>
                <!-- Me gustó esta forma de selected para una lista filtrada individualmente -->
                <option value="2" <?php if ($user->rol_name == "Administrador") {echo "selected"; }?>>Administrador</option>  
                <option value="1" <?php if ($user->rol_name == "Registrados") {echo "selected"; }?>>Registrados</option>
                             
            </select>             
            </div>          
        
            <br />
            <button type="submit" name="editarUsuario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Usuario</button>

            <button type="submit" name="borrarUsuario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Usuario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       