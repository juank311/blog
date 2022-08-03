<?php 

include('includes_lvl_2.php');
include('../models/articles.php');


?>
<?php

//primero es instanciar la conexion con la base de datos 
$dataBase = new classConnection_mysql;
$db = $dataBase->connection();

//segundo es instacial el objeto que mostrará los resultados

$table_result = new classArticle($db);
$articles = $table_result->search();
//var_dump($articles);

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-6">
            <h3>Lista de Artículos</h3>
        </div>
        <div class="col-sm-4 offset-2">
            <a href="crear_articulo.php" class="btn btn-success w-100"><i class="bi bi-plus-circle-fill"></i> Nuevo Artículo</a>
        
        </div>
    </div>
    <div class="row mt-2 caja">
        <div class="col-sm-12">
        <?php if (isset($_GET['mensaje'])) : ?>
                    <!-- mensaje --> 
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?= $_GET['mensaje']?></strong> 
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
            <table id="tblArticulos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Imagen</th>
                        <th>Texto</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $row) : ?>
                        <tr>
                            <td><?php echo $row->id; ?></td>
                            <td><?php echo $row->title; ?></td>
                            <td>
                                <img class="img-" src="<?php echo RUTA_USER; ?>img/articulos/<?php echo $row->picture ?>" style="width:130px;">
                            </td>
                            <td><?php echo $row->text; ?></td>
                            <td><?php echo $row->creation_date; ?></td>
                            <td>
                                <a href="editar_articulo.php?id=<?php echo $row->id ?>" class="btn btn-warning">Editar <i class="bi bi-pencil-fill"></i></a>
                                <a href="borrar_articulo.php?id=<?php echo $row->id ?>" class="btn btn-danger">Borrar<i class="bi bi-person-bounding-box"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include("../includes/footer.php") ?>

    <script>
        $(document).ready(function() {
            $('#tblArticulos').DataTable();
        });
    </script>