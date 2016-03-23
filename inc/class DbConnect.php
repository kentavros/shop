<?php
class DbConnect{
    private $host;
    private $login;
    private $pass;
    private $db_name;
    private $dbc;
// при помощи __construct  заносим значения свойствам
    public function __construct ($host, $login, $pass, $db_name){
        $this->host = $host;
        $this->login = $login;
        $this->pass = $pass;
        $this->db_name = $db_name;
    }
    //метод для соединения с БД
    public function connect (){
        $this->dbc = mysqli_connect($this->host, $this->login, $this->pass, $this->db_name);
    }
    //получение идентификатора соединения
    public function get_connection (){
        return $this->dbc;
    }

    //закрытие соединения с БД
    public function db_close (){
        return mysqli_close($this->dbc);
    }
}
?>