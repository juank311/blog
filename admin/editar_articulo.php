<?php include("../includes/header.php");

//primero es instanciar la conexion con la base de datos 
$dataBase = new classConnection_mysql;
    $db = $dataBase->connection();

//Se instancia el objeto que mostrará el resultado 
$classArticle = new classArticle($db);
    $id = $classArticle->id = $_GET['id'];
    $article = $classArticle->search_one($id);

    //traer funcion para actualizar
if (isset($_POST['editarArticulo']))
{   
    $title = $_POST['title'];
    $text = $_POST['text'];
    $picture = $_FILES['picture']['name'];
    
    echo $picture;
    
    if ($classArticle->update($id, $title, $text, $picture)) 
    {
        
        //header('location:'.RUTA_ADMIN.'articulos.php');
        echo "actualizado correctamente";

    } else {
        echo "No actualizado";
    }
    
}

?>

<div class="row">

</div>

<div class="row">
    <div class="col-sm-6">
        <h3>Editar Artículo</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">

            <input type="hidden" name="id" value="4">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $article->title; ?>">
            </div>

            <div class="mb-3">
                <img class="img-fluid img-thumbnail" src="<?php echo RUTA_USER; ?>img/articulos/<?php echo $article->picture;?>">
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="picture" id="picture" placeholder="Selecciona una imagen">  
            </div>
            
            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="text" style="height: 200px"><?php echo $article->text; ?></textarea>           
            </div>  
            

            <br />
            <button type="submit" name="editarArticulo" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i>Editar Artículo</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php");



?> 

