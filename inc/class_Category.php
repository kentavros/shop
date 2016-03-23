<?php
class Category {
    private $id;
    private $name;

    public function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }

    public static function find ($dbc){
        $query = "SELECT * FROM categories";
        $result = mysqli_query($dbc, $query);
        while ($row=mysqli_fetch_array($result)) {
            $arr[] = new Category($row['id'], $row['name']);

        }
        return $arr;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }

    public static function findById ($dbc, $category_id){
        $query = "SELECT * FROM categories WHERE id ='".$category_id."'";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        return new Category($row['id'], $row['name']);
    }
    //Метод поиска в таблице БД по имени
    public static function findByName ($dbc, $name){
        $query = "SELECT * FROM categories WHERE name='".$name."'";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        return new Category($row['id'], $row['name']);
    }

    //проверяем существование данных в таблице БД
    public static function categoryExist($dbc, $name){
        // Проверяем, а нет ли такого имяни уже в таблице?
        $query = "SELECT * FROM categories WHERE name='".$name."'";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 0){
            // Такого имяни нет - возвращаем false
            return false;
        } else {
            //Такое имя есть - вернуть true
            return true;
        }
    }
    //Метод добавления категории (объекта) по имени в таблицу БД
    public static function addCategory($dbc, $name){
        $query = "INSERT INTO categories (name) VALUES ('".$name."')";
        $result = mysqli_query($dbc, $query);
        if ($result){
            return true;
        } else {
            return false;
        }
    }
    //Метод Update - служит для обновления информации(имени) по существующей категорие
    public static function updateCategory($dbc, $id, $name){
        $query = "UPDATE categories SET name = '".$name."' WHERE id='".$id."'";
        return mysqli_query($dbc, $query);
    }
    //Метод Delete - удаляет категорию по id
    public static function deleteCategory($dbc, $id){
        $query = "DELETE FROM categories WHERE id='".$id."'";
        $result = mysqli_query($dbc, $query);
        if ($result) {
            //успешное удаление
            return true;
        }
        else {
            //Удаление не удалось - что-то пошло не так
            return false;
        }
    }

}
?>