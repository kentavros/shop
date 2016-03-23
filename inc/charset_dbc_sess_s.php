<?php
//Кодировка - явный UTF-8
header('content-type: text/html; charset=utf-8');
//Подключаем класс
include 'class DbConnect.php';
include 'class_Category.php';
include 'class_Product.php';
include 'class_User.php';
include 'class_Basket.php';
//Соединение с БД
$obj_conn = new DbConnect('localhost', 'root', '', 'shop');
$obj_conn->connect();
//Создание обекта КОРЗИНА
$basket = new Basket();
//Старт сессии
session_start();
?>