<?php include('includes_lvl_2.php');
      include('../models/comments.php');
      
//primero es instanciar la conexion con la base de datos 
$dataBase = new classConnection_mysql;
    $db = $dataBase->connection();

//Se instancia el objeto que mostrará el resultado 
$classComments = new classComments($db);
    $id = $_GET['id'];
    $comment = $classComments->search_one($id);
    //var_dump($comment);

//Se llama la clase de busqueda global, para analizar si existe la imagen antigua 

//traer funcion para actualizar
if (isset($_POST['editarComentario']))
{   
    $id_comment = $_POST['cambiarEstado'];
    
    echo $picture;
    
    if ($classComments->update($id, $id_comment)) 
    {
        header('location:'.RUTA_ADMIN.'comentarios.php');
        
    } else {
        echo "No actualizado";
    } 
}

if (isset($_POST['borrarComentario']))
{     
    if ($classComments->delete($id)) 
    {
        header('location:'.RUTA_ADMIN.'comentarios.php');
        
    } else {
        echo "No actualizado";
    } 
}



?>
<div class="row">
          
    </div>

    <div class="row">
        <div class="col-sm-6 offset-3">
        <div class="row">
        <div class="col-sm-6">
            <h3>Editar Comentario</h3>
        </div>            
    </div>
        <form method="POST" action=""> 

            <input type="hidden" name="id" value="4"> <!-- Sirve para enviar datos por el metodo POST -->

            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px" readonly>
                <?php echo $comment->name_comments?>
                </textarea>              
            </div>               

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" value="<?php echo $comment->name_user?>" readonly>               
            </div>

            <div class="mb-3">
                <label for="cambiarEstado" class="form-label">Cambiar estado:</label>
                <select class="form-select" name="cambiarEstado" aria-label="Default select example">
                <option value="">--Seleccionar una opción--</option>
                <option value="1"<?php if ($comment->name_status == "Aprobado") { echo "selected";}?>>Aprobado</option>
                <option value="0"<?php if ($comment->name_status == "No aprobado") { echo "selected";}?>>No Aprobado</option>              
                </select>                 
            </div>  

            <br />
            <button type="submit" name="editarComentario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Comentario</button>

            <button type="submit" name="borrarComentario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Comentario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       