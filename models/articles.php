<?php

class classArticle
{
    //se definen las propiedad privadas 
    private $conn;
    private $table = "articles";

    //se definen las propiedad publicas con las que trabajará la clase (normalmente son las propiedades que contiene la base de datos)

    public $id;
    public $title;
    public $picture;
    public $text;
    public $creation_date;


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
        $query_search = 'SELECT * FROM ' . $this->table;
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
        $query_search = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
        $stmt_search = $this->conn->prepare($query_search);

        $id = htmlspecialchars(strip_tags($id));

        $stmt_search->bindParam(1, $id, PDO::PARAM_INT);
        $stmt_search->execute();
        $result = $stmt_search->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    //Insertar articulo con validacion e insercion de imagen
    public function insert($picture)
    {
        if (isset($picture)) {
            //Recogemos el archivo enviado por el formulario
            // $picture = $_FILES['picture']['name'];
            //Si el picture contiene algo y es diferente de vacio
            if (isset($picture) && $picture != "") {
                //Obtenemos algunos datos necesarios sobre el picture
                $tipo = $_FILES['picture']['type'];
                $tamano = $_FILES['picture']['size'];
                $temp = $_FILES['picture']['tmp_name'];
                //Se comprueba si el picture a cargar es correcto observando su extensión y tamaño
                if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
                    echo '<div><b>Error. La extensión o el tamaño de los pictures no es correcta.<br/>
                    - Se permiten pictures .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
                } else {
                    //Si la imagen es correcta en tamaño y tipo
                    //Se intenta subir al servidor
                    if (move_uploaded_file($temp, '../img/articulos/' . $picture)) {
                        //Cambiamos los permisos del picture a 777 para poder modificarlo posteriormente
                        chmod('../img/articulos/' . $picture, 0777);
                        //Mostramos el mensaje de que se ha subido co éxito
                        /*  echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                        //Mostramos la imagen subida
                        echo '<p><img src="images/'.$picture.'"></p>'; */
                        $this->picture =  $picture;
                    } else {
                        //Si no se ha podido subir la imagen, mostramos un mensaje de error
                        echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                    }
                }
            }
        }
        //Consulta a base de datos para insercion
        $query_insert = 'INSERT INTO ' . $this->table . ' (title, picture, text) VALUES (?, ?, ?) ';
        $stmt_insert = $this->conn->prepare($query_insert);
        //validacion de datos
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->text = htmlspecialchars(strip_tags($this->text));


        $stmt_insert->execute([$this->title, $this->picture, $this->text]);

        if ($stmt_insert) {
            return true;
        } else {
            return false;
        }
    }

    //Insertar articulo con validacion e insercion de imagen
    public function update($id, $title, $text, $picture)
    {
        if ($picture == "" || !isset($picture) || empty($picture) || $picture == null) 
        {   echo "entro por aqui";
            //Consulta a base de datos para insercion
            $query_update = 'UPDATE ' . $this->table . ' SET title = :title, text = :text WHERE id = :id';
            $stmt_update = $this->conn->prepare($query_update);
            //validacion de datos
            /* $this->title = htmlspecialchars(strip_tags($this->title));
            $this->text = htmlspecialchars(strip_tags($this->text)); */

            $stmt_update->bindParam(':id', $id);
            $stmt_update->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt_update->bindParam(':text', $text);
            
            $stmt_update->execute();

            if ($stmt_update) {
                return true;
            } else {
                return false;
            }
        } else 
            {
                //Recogemos el archivo enviado por el formulario
                //$picture = $_FILES['picture']['name'];
                //Si el picture contiene algo y es diferente de vacio
                if (isset($picture) && $picture != "") 
                {   echo "nuevo";
                    //Obtenemos algunos datos necesarios sobre el picture
                    $tipo = $_FILES['picture']['type'];
                    $tamano = $_FILES['picture']['size'];
                    $temp = $_FILES['picture']['tmp_name'];
                    //Se comprueba si el picture a cargar es correcto observando su extensión y tamaño
                    if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 20000000))) 
                    {
                        echo '<div><b>Error. La extensión o el tamaño de los pictures no es correcta.<br/>
                            - Se permiten pictures .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
                    } else 
                    {
                        //Si la imagen es correcta en tamaño y tipo
                        //Se intenta subir al servidor
                        if (move_uploaded_file($temp, '../img/articulos/' . $picture)) 
                        {
                            //Cambiamos los permisos del picture a 777 para poder modificarlo posteriormente
                            chmod('../img/articulos/' . $picture, 0777);
                            //Mostramos el mensaje de que se ha subido co éxito
                            /*  echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                                //Mostramos la imagen subida
                                echo '<p><img src="images/'.$picture.'"></p>'; */
                            ///$this->picture =  $picture;
                            //Consulta a base de datos para insercion
                            
                            $query_update = 'UPDATE ' . $this->table . ' SET title = :title, picture = :picture, text = :text WHERE id = :id';
                            $stmt_update = $this->conn->prepare($query_update);
                            //validacion de datos
                          
                            $stmt_update->bindParam(':id', $id);
                            $stmt_update->bindParam(':title', $title, PDO::PARAM_STR);
                            $stmt_update->bindParam(':text', $text);
                            $stmt_update->bindParam(':picture', $picture);

                            $update = $stmt_update->execute();

                            if ($update) {
                                return true;
                            } else {
                                return false;
                                
                            }

                        } else {
                            //Si no se ha podido subir la imagen, mostramos un mensaje de error
                            echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                        }
                    }
                }
            }

    }

    //Leer aticulos uno solo 
    public function delete()
    {

        //se define la query.
        $query_delete = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
        $stmt_delete = $this->conn->prepare($query_delete);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt_delete->bindParam(1, $this->id, PDO::PARAM_INT);
        $stmt_delete->execute();
        $delete_correct = $stmt_delete;
        if ($delete_correct) {
            return true;
        } else {
            return false;
        }
    }
}
