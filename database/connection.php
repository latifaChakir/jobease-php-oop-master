<?php
class Database{
    public $conn;
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public function __construct($servername,$username,$password,$dbname){
        $this->servername=$servername;
        $this->username=$username;
        $this->password=$password;
        $this->dbname=$dbname;
        $this->conn=new mysqli($this->servername,$this->username,$this->password,$this->dbname);
        if(!$this->conn){
            die("error!".mysqli_error($this->conn));

        }

    }
    public function getConnection() {
        return $this->conn;
    }

}
$database = new Database('localhost', 'root', '', 'jobeasy');
$conn = $database->getConnection();


?>

