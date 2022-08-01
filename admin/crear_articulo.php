<?php include('includes_lvl_2.php');
include('../models/articles.php');


//primero es instanciar la conexion con la base de datos 
$dataBase = new classConnection_mysql;
$db = $dataBase->connection();

//segundo es instacial el objeto que mostrará los resultados

if (isset($_POST['crearArticulo'])) {
    /*  //Recogemos el archivo enviado por el formulario
   $picture = $_FILES['picture']['name'];
   //Si el picture contiene algo y es diferente de vacio
   if (isset($picture) && $picture != "") 
   {
      //Obtenemos algunos datos necesarios sobre el picture
      $tipo = $_FILES['picture']['type'];
      $tamano = $_FILES['picture']['size'];
      $temp = $_FILES['picture']['tmp_name'];
      //Se comprueba si el picture a cargar es correcto observando su extensión y tamaño
     if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
        echo '<div><b>Error. La extensión o el tamaño de los pictures no es correcta.<br/>
        - Se permiten pictures .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
     }
     else {
        //Si la imagen es correcta en tamaño y tipo
        //Se intenta subir al servidor
        if (move_uploaded_file($temp, '../img/articulos/'.$picture)) {
            //Cambiamos los permisos del picture a 777 para poder modificarlo posteriormente
            chmod('../img/articulos/'.$picture, 0777);
            //Mostramos el mensaje de que se ha subido co éxito
           /*  echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
            //Mostramos la imagen subida
            echo '<p><img src="images/'.$picture.'"></p>'; 
        }
        else {
           //Si no se ha podido subir la imagen, mostramos un mensaje de error
           echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
        }
      }
   }  */

    $result = new classArticle($db);

    $result->title = $_POST['title'];
    $result->text = $_POST['text'];
    $picture = $_FILES['picture']['name'];

    $insert = $result->insert($picture);

    if ($insert == true) {
        echo 'Ingresado correctamente';
    } else {
        echo 'no SE PUDO INGRESAR';
    }
}


?>

<div class="row">

</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <div class="row">
            <div class="col-sm-6">
                <h3>Crear un Nuevo Artículo</h3>
            </div>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Título:</label>
                <input type="text" class="form-control" name="title" id="titulo" placeholder="Ingresa el título">
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="picture" id="picture" placeholder="Selecciona una imagen">
            </div>
            <div class="mb-3">
                <label for="texto">Texto</label>
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="text" style="height: 200px"></textarea>
            </div>

            <br />
            <button type="submit" name="crearArticulo" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Artículo</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>