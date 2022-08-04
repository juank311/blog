<?php

class classUsers
{
    //se definen las propiedad privadas 
    private $conn;
    private $table = "users";

    //se definen las propiedad publicas con las que trabajará la clase (normalmente son las propiedades que contiene la base de datos)

    public $id;
    public $name;
    public $email;
    public $rol_id;
    public $creation_date;
    public $error;
    public $mensaje;
    public $email_exist;
    public $SESSION;


    //se define el constructor que se ejecuta siempre sin importar nada, el cual establecerá la conexion con la base de datos.

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //ahora se define el metodo o la funcion qque realiza la primera actividad de mostrar el contenido de la base de datos (search)

    //Leer aticulos
    public function search()
    {

        //se define la query.
        $query_search = 'SELECT u.id AS id_user, u.name AS name_user, u.email AS email_user, u.rol_id AS id_roll_user, u.creation_date AS creation_date_user, r.name AS rol_name
        FROM ' . $this->table. ' u INNER JOIN roles r ON r.id = u.rol_id';
        //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
        $stmt_search = $this->conn->prepare($query_search);
        $stmt_search->execute();
        $result = $stmt_search->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function search_email($email_exist)
    {

        //se define la query.
        $stmt_search = 'SELECT u.id AS id_user, u.name AS name_user, u.email AS email_user, u.rol_id AS id_roll_user, u.creation_date AS creation_date_user, r.name AS rol_name
        FROM ' . $this->table. ' u INNER JOIN roles r ON r.id = u.rol_id WHERE u.email = :email_exist';
        //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
        $stmt_search = $this->conn->prepare($stmt_search);
        $email_exist = htmlspecialchars(strip_tags($email_exist));
        $stmt_search->bindParam(':email_exist', $email_exist, PDO::PARAM_STR);
        $stmt_search->execute();
        $result = $stmt_search->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            $this->email_exist = true;
            $this->error = "El correo ya existe";
        }else {
            $this->email_exist = false;
        }
        
    }

    //Leer aticulos uno solo 
    public function search_one($id)
    {
        //se define la query.
        $query_search = 'SELECT u.id AS id_user, u.name AS name_user, u.email AS email_user, u.password AS password, u.rol_id AS id_roll_user, u.creation_date AS creation_date_user, r.name AS rol_name
        FROM ' . $this->table. ' u INNER JOIN roles r ON r.id = u.rol_id WHERE u.id = ? LIMIT 0,1';
        //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
        $stmt_search = $this->conn->prepare($query_search);

        $id = htmlspecialchars(strip_tags($id));

       // $stmt_search->bindParam(1, $id, PDO::PARAM_INT);
        $stmt_search->execute([$id]);
        $result = $stmt_search->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    //Insertar articulo con validacion e insercion de imagen
    public function insert($name, $email, $password, $confirm_password, $rol_id)
    {
        if ($password != $confirm_password) 
        {
            $this->error = "Las contraseñas no concuerdan";
        }else 
        {
            $query_insert = 'INSERT INTO ' . $this->table . ' (name, email, password, rol_id) VALUES (?, ?, ?, ?) ';
            $stmt_insert = $this->conn->prepare($query_insert);
            //validacion de datos
            $name = htmlspecialchars(strip_tags($name));
            $email = htmlspecialchars(strip_tags($email));
            $password = htmlspecialchars(strip_tags($password));
            $rol_id = htmlspecialchars(strip_tags($rol_id));

            $stmt_insert->execute([$name, $email, $password, $rol_id]);

            if ($stmt_insert) {
                return true;
            } else {
                return false;
            }
        }
    }

    //Insertar articulo con validacion e insercion de imagen
    public function update($name, $email, $rol_id, $id)
    {
        if  (empty($name) || empty($email) || empty($rol_id)) 
        {   
            return $this->error = "Datos vacios";

        }else {
            $query_update = 'UPDATE ' . $this->table . ' SET name = :name, email = :email, rol_id = :rol_id WHERE id = :id';
            $stmt_update = $this->conn->prepare($query_update);
            //validacion de datos
          
            $stmt_update->bindParam(':id', $id);
            $stmt_update->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt_update->bindParam(':email', $email);
            $stmt_update->bindParam(':rol_id', $rol_id);

            $update = $stmt_update->execute();

            if ($update) {
                $texto = "Usuario actualizado correctamente";
                $this->mensaje = $texto;
                $this->mensaje;
                return $update = true;
            } else {
                $this->error = "Usuario no se pudo actualizar";
                
            }   
        }
    }                     
                            
    //Leer aticulos uno solo 
    public function delete($id)
    {

        //se define la query.
        $query_delete = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
        $stmt_delete = $this->conn->prepare($query_delete);

        $this->id = htmlspecialchars(strip_tags($id));

        $stmt_delete->bindParam(1, $id, PDO::PARAM_INT);
        $stmt_delete->execute();
        $delete_correct = $stmt_delete;
        if ($delete_correct) {
            return true;
        } else {
            return false;
        }
    }
    
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
                    {   $_SESSION['data_employee'] = $email_verification;
                        return $this->mensaje = true;
                        //header('Location: acceder.php');
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
