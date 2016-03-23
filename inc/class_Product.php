<?php
class Product {
    private $id;
    private $name;
    private $price;
    private $category_id;


    public function __construct($id, $name, $price, $category_id){
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->category_id = $category_id;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getCategory_id(){
        return $this->category_id;
    }
    public static function find ($dbc) {
        $query = "SELECT * FROM tools";
        $result = mysqli_query($dbc,$query);
        while ($row=mysqli_fetch_array($result)) {
            $arr[] = new Product($row['id'], $row['name'], $row['price'], $row['category_id']);
        }
        if (is_array($arr)){
            return $arr;
        }
        else {
            return 'Список Пуст';
        }
    }
    public static function findByCategoryId ($dbc, $category_id) {
        $query = "SELECT * FROM tools WHERE category_id ='".$category_id."'";
        $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)){
            $arr[] = new Product($row['id'], $row['name'], $row['price'], $row['category_id']);
        }
        if (is_array($arr)){
            return $arr;
        }
        else {
            return 'Список Пуст';
        }
    }
    //метод поиска продукта по персональному ID
    public static function findById($dbc, $id){
        $query = "SELECT * FROM tools WHERE id = '".$id."'";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        return new Product ($row['id'], $row['name'], $row['price'], $row['category_id']);
    }
}
?>