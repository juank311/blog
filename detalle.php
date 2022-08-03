<?php session_start();
include("admin/includes_lvl_1.php");
include("models/articles.php");
include("models/comments.php");

$classDataBase = new classConnection_mysql;
$db = $classDataBase->connection();

$classArticles = new classArticle($db);
$classComments = new classComments($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$article = $classArticles->search_one($id);

if (isset($_POST['enviarComentario'])) {
    $comments = $_POST['comments'];
    $user_id = $_SESSION['data_employee']->id;
    $article_id =  $id;
    $status = 0;

    if (!isset($comments)) {
        $error = "No ha escrito ningun comentario";
        echo $error;
    } else {
        
        $insert = $classComments->insert($comments, $user_id, $article_id, $status);
        if ($insert == true) {
            $mensaje = "Comentario añadido exitosamente, espere que un administrador lo apruebe.";
        } else {
            $error = "Error, no se pudo añadir el comentario";
        }
    }
}
?>


<div class="row">

</div>

<div class="container-fluid">

    <div class="row">

        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>
        <?php if (isset($mensaje)) : ?>
            <!-- mensaje -->
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?= $mensaje; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
        <!-- error -->
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= $error; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1><?= $article->title ?></h1>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid img-thumbnail" src="<?= RUTA_USER ?>img/articulos/<?= $article->picture ?>">
                    </div>

                    <p><?= $article->text ?></p>

                </div>
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-6 offset-3">
            <form method="POST" action="">
                <input type="hidden" name="articulo" value="">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" value="<?= $_SESSION['data_employee']->email ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="comentario">Comentario</label>
                    <textarea class="form-control" name="comments" style="height: 200px"></textarea>
                </div>

                <br />
                <button type="submit" name="enviarComentario" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Comentario</button>
            </form>
        </div>
    </div>

</div>

<div class="row">
    <h3 class="text-center mt-5">Comentarios</h3>

    <h4><i class="bi bi-person-circle"></i> juangarcia@gmail.com</h4>
    <p>texto comentario demo</p>

</div>

</div>
<?php include("includes/footer.php") ?>