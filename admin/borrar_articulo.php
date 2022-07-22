<?php include("../includes/header.php");


 //primero es instanciar la conexion con la base de datos 
 $dataBase = new classConnection_mysql;
 $db = $dataBase->connection();

 //segundo es instacial el objeto que mostrará los resultados

 $classArticle = new classArticle($db);
 $classArticle->id = $_GET['id'];
 $article = $classArticle->search_one();

 //traer funcion para borrar 
if (isset($_POST['borrarArticulo'])) 
{
    $delete = $classArticle->delete();
    if ($delete) {
        echo "borrado exitosamente";
    }else {
        echo "no se pudo borrar exitosamente";
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
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $article->title; ?> " readonly>               
            </div>

            <div class="mb-3">
                <img class="img-fluid img-thumbnail" src="<?php echo RUTA_USER;?>img/articulos/<?php echo $article->picture?>" readonly>
            </div>

            <div class="mb-3">
                <label for="titulo" class="form-label">Texto:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $article->text; ?> " readonly>               
            </div>        
        
            <br />
            <button type="submit" name="borrarArticulo" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Artículo</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>