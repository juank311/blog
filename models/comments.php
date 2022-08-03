<?php

class classComments
{
    //se definen las propiedad privadas 
    private $conn;
    private $table = "comments";

    //se definen las propiedad publicas con las que trabajará la clase (normalmente son las propiedades que contiene la base de datos)

    public $id;

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
        $query_search = 'SELECT 
        c.id AS id_comments, c.comments AS name_comments, c.creation_date AS date_comments, c.user_id AS user_id, c.article_id AS article_id, c.status AS status, 
        u.id AS id_user, u.email AS name_user, 
        a.id AS id_article, a.title AS title_article,
        s.name_status AS name_status
        FROM '.$this->table.' c 
        LEFT JOIN articles a 
        ON c.article_id = a.id
        LEFT JOIN users u 
        ON  c.user_id  = u.id
        LEFT JOIN status s 
        ON s.id = c.status';
        //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
        $stmt_search = $this->conn->prepare($query_search);
        $stmt_search->execute();
        $result = $stmt_search->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    //Leer aticulos uno solo 
    public function search_one($id)
    {
        //se define la query.
        $query_search = 'SELECT 
        c.id AS id_comments, c.comments AS name_comments, c.creation_date AS date_comments, c.user_id AS user_id, c.article_id AS article_id, c.status AS status, 
        u.id AS id_user, u.email AS name_user, 
        a.id AS id_article, a.title AS title_article,
        s.name_status AS name_status
        FROM '.$this->table.' c 
        LEFT JOIN articles a 
        ON c.article_id = a.id
        LEFT JOIN users u 
        ON  c.user_id  = u.id
        LEFT JOIN status s 
        ON s.id = c.status 
        WHERE c.id = ? 
        LIMIT 0,1';

        //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
        $stmt_search = $this->conn->prepare($query_search);

        $id = htmlspecialchars(strip_tags($id));

       // $stmt_search->bindParam(1, $id, PDO::PARAM_INT);
        $stmt_search->execute([$id]);
        $result = $stmt_search->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    //Insertar articulo con validacion e insercion de imagen
    public function insert($comments, $user_id, $article_id, $status)
    {
        $query_insert = 'INSERT INTO ' . $this->table . ' (comments, user_id, article_id, status) VALUES (:comments, :user_id, :article_id, :status) ';
        $stmt_insert = $this->conn->prepare($query_insert);
         //validacion de datos
        
        $comments = htmlspecialchars(strip_tags($comments));
        $user_id = htmlspecialchars(strip_tags($user_id));
        $article_id = htmlspecialchars(strip_tags($article_id));
        $status = htmlspecialchars(strip_tags($status));
        
        $stmt_insert->bindParam(':comments', $comments, PDO::PARAM_STR);
        $stmt_insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_insert->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt_insert->bindParam(':status', $status, PDO::PARAM_INT);

        $stmt_insert->execute();

            if ($stmt_insert) {
                return true;
            } else {
                return false;
            }
    }
    

    //Insertar articulo con validacion e insercion de imagen
    public function update($id, $id_comment)
    {
            $query_update = 'UPDATE ' . $this->table . ' SET status = :status WHERE id = :id';
            $stmt_update = $this->conn->prepare($query_update);
            //validacion de datos
          
            $stmt_update->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_update->bindParam(':status', $id_comment, PDO::PARAM_INT);
          

            $update = $stmt_update->execute();

            if ($update) 
            {
                $texto = "Usuario actualizado correctamente";
                $this->mensaje = $texto;
                $this->mensaje;
                return $update = true;
            } else {
                $this->error = "Usuario no se pudo actualizar";
                
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

}