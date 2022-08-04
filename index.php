<?php session_start();
include("admin/includes_lvl_1.php");
include("models/articles.php");

$classDataBase = new classConnection_mysql;
$db = $classDataBase->connection();

$classArticles = new classArticle($db);

    $articles = $classArticles->search();
?>
 <?php if (isset($_SESSION['activo'])) : ?>
<div class="container-fluid">
    <h1 class="text-center">Artículos</h1>
    <div class="row">

        <?php foreach($articles AS $row) : ?>
        <div class="col-sm-4">
            <div class="card">
                <img src="<?= RUTA_USER?>img/articulos/<?= $row->picture?>" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?= $row->title ?></h5>
                    <p><strong><?= formatear_fecha($row->creation_date) ?></strong></p>
                    <p class="card-text"><?= texto_corto($row->text) ?></p>
                    <a href="detalle.php?id=<?= $row->id ?>" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
    </div>
</div>
<?php endif; ?>
<?php include("includes/footer.php") ?>