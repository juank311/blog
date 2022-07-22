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

        public function search()
        {
            //se define la query.
            $query_search = 'SELECT * FROM '.$this->table;
            //se prepara la consulta en este caso será de forma OBJ por lo tanto usaremos query.
            $stmt_search = $this->conn->prepare($query_search);
            $stmt_search->execute();
            $result = $stmt_search->fetchAll(PDO::FETCH_OBJ);
            return $result;          
        }

        public function insert()
        {
            $query_insert = 'INSERT INTO '.$this->table.' (title, picture, text) VALUES (?, ?, ?) ';
            $stmt_insert = $this->conn->prepare($query_insert);

            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->text = htmlspecialchars(strip_tags($this->text));

            $stmt_insert->execute([$this->title, $this->picture, $this->text]);

            if ($stmt_insert) {
                return true;
            }else{
                return false;
            }
            
        }







}
?>