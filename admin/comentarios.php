<?php include("../includes/header.php") ?>

<?php

$classDataBase = new classConnection_mysql;
$db = $classDataBase->connection();


$classComments = new classComments($db);

$comments =  $classComments->search();
if ($comments) {
    //echo "correcto";
} else {
    //echo "no mostró nada";
}

?>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Comentarios</h3>
    </div>       
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
            <table id="tblContactos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comentario</th>
                        <th>Usuario</th>
                        <th>Artículo</th>
                        <th>Estado</th>
                        <th>Fecha de creación</th>                                          
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($comments AS $row) :?>
                    <tr>
                        <td><?php echo $row->id_comments; ?></td>
                        <td><?php echo $row->name_comments; ?></td>
                        <td><?php echo $row->name_user; ?></td>
                        <td><?php echo $row->title_article; ?></td> 
                        <td><?php echo $row->name_status; ?></td>
                        <td><?php echo $row->date_comments; ?>2</td>              
                        <td>
                            <a href="editar_comentario.php?id=<?php echo $row->id_comments ;?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>                            
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>       
            </table>
    </div>
</div>
<?php include("../includes/footer.php") ?>

<script>
    $(document).ready( function () {
        $('#tblContactos').DataTable();
    });
</script>