<?php include("../includes/header.php") ?>
<?php

$classDataBase = new classConnection_mysql;
$db = $classDataBase->connection();


$classUsers = new classUsers($db);

$search =  $classUsers->search();
if ($search) {
    //echo "correcto";
} else {
    //echo "no mostró nada";
}

//print_r($search) 

?>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Usuarios</h3>
    </div>
                    <?php if (isset($_GET['mensaje'])) : ?>
                    <!-- mensaje --> 
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo $_GET['mensaje']; ?></strong> 
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
                              
    <div class="row mt-2 caja">
        <div class="col-sm-12">
            <table id="tblUsuarios" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($search as $row) : ?>
                        <tr>
                            <td><?php echo $row->id_user; ?></td>
                            <td><?php echo $row->name_user; ?></td>
                            <td><?php echo $row->email_user; ?></td>
                            <td><?php echo $row->rol_name; ?></td>
                            <td><?php echo $row->creation_date_user; ?></td>
                            <td>
                                <a href="editar_usuario.php?id=<?php echo $row->id_user ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>
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
            $('#tblUsuarios').DataTable();
        });
    </script>