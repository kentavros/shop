<?php
class Basket {

    //метод добавления продукта в Session['basket']
    public function addProduct($id){
        $_SESSION['basket'][]['id'] = $id;
        $array_count = count($_SESSION['basket'])-1;
        return $_SESSION['basket'][$array_count]['id'];
    }
    //Метод получения продуктов из корзины (массив продуктов)
    public function getProduct($dbc){
        $array_product = array();
        foreach($_SESSION['basket'] as $array){
            foreach ($array as $id){
                $query = "SELECT * FROM tools WHERE id='".$id."'";
                $result = mysqli_query($dbc, $query);
                $row = mysqli_fetch_array($result);
                $array_product[]= new Product($row['id'],$row['name'],$row['price'],$row['category_id']);
            }
        }
        return $array_product;
    }
    //Метод удаления продукта из корзины
    public function delete($id) {
        foreach($_SESSION['basket'] as $key => $array){
                if ($_SESSION['basket'][$key]['id'] == $id){
                    unset($_SESSION['basket'][$key]['id']);
                    break;
                }
        }
    }
    //очистка корзины путем убийства массива
    public function clean(){
        unset($_SESSION['basket']);
    }
}