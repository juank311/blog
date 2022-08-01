 public function login($email, $password)
    {
        if (!empty($_POST['email']) && $_POST['email'] != "" && !empty($_POST['password']) && $_POST['password'] != "") 
        {
            //ejecucion de la consulta 
            $query_search_email = 'SELECT * FROM '.$this->table.' WHERE email = :email';
            $stmt_search_email = $this->conn->prepare($query_search_email);
            $stmt_search_email->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt_search_email->execute();
            $email_verification = $stmt_search_email->fetch(PDO::FETCH_OBJ);
            //$this->datas = $email_verification;
                if ($email_verification) 
                {
                    if ($password == $email_verification->password)
                    {
                        /* $this->_SESSION = $_SESSION['activo']= true;
                        $this->datas = $_SESSION['data_employee']=$email_verification; */
                        $this->mensaje = "Entro correctamente";
                    } else{
                    $this->error = "La Contraseña es incorrecta";
                    }
                } else {
                $this->error = "El correo es invalido";
                }
        } else {
            $this->error = "Existen campos vacios"; }
    }
}



------------------}

<?php
$dataBase = new classConnection_mysql;
$db = $dataBase->connection();
$classUsers = new classUsers($db);

if (isset($_POST['acceder'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $classUsers->login($email, $password);
}
?>
<!-- error Alt+Shift+F -->
<?php if (isset($classUsers->error)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $classUsers->error; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>
<?php if (isset($error)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $error; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>
<?php if (isset($classUsers->mensaje)) : ?>
    <?php header('Location:index.php');
    ?>
<?php endif ?>