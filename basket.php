<?php
//Установка кодировки, соеденение с БД, старт сессии
include 'inc/charset_dbc_sess_s.php';
//получаем id продукта (обробатываем значения посланной формы) через POST и заносим его в таблицу Basket (временную)
//и делаем редирект
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Если были посланы данные то заносим их в массив $_SESSION['basket'][]['id']
    //$_SESSION['basket'][]['id']= $_POST['id'];
    $basket->addProduct($_POST['id']);
    //делаем редирект чтоб избавиться от повторного занесения данных при обновление страницы Ф5
    //а так же передаем переменую back = $_POST['category_id'] - для применения её в самом низу на ссылке "Продолжить покупку" и
    // попадание туда откуда пришли (гугл тут не причем )) )
    header('Location: basket.php?back='.$_POST['category_id']);
}
//Удаление позиции в списке
//Если существует $_GET['id'] - значит нажата кнопка удалить - выполняем условие
if (isset($_GET['id'])){
    $basket->delete($_GET['id']);
    header('Location: basket.php?mess=1');
}
//Блок Action - ДЕЙСТВИЙ
switch ($_GET['act']){
    case '1':
        $basket->clean();
        break;
}
//Шапка сайта (Доктайп  и т.д.)
$title = 'Интернет Магазин Инструмента';
include 'inc/site_head.php';
?>
<div align="center">САМЫЙ РАЗНЫЙ ИНСТРУМЕНТ<img alt="logo" src="images/tools.jpg" title="Логотип фирмы рога и копыто" width="120" /></div>
<hr />
<h2>Содержимое корзины</h2>
<?php
if (isset($_SESSION['basket'])){
    echo '<table><tr><td><b>№</b></td><td><b>Производитель</b></td><td><b>Модель</b></td><td><b>Цена</b></td><td><b>Удалить</b></td></tr>';
    $num = 1;
        foreach ($basket->getProduct($obj_conn->get_connection()) as $product) {
            echo '<tr><td>' . $num . '.</td>
        <td>' . Category::findById($obj_conn->get_connection(), $product->getCategory_id())->getName() . '</td>
        <td>' . $product->getName() . '</td><td>' . $product->getPrice() . '</td>
        <td><a href="basket.php?id=' . $product->getId() . '">Удалить</a></td></tr>';
            $num++;
            $price += $product->getPrice();
        }
    echo '</table>';
    echo '<hr />';
    echo '<b>Сумма Вашего заказа составляет: '.sprintf('%0.2f', $price).' грн.</b>';
    echo '<hr />';
    echo '<a href="basket.php?act=1" >Очистить корзину</a><hr />';
}
else {
    echo '<p class="error">Корзина пуста !!!</p>';
}
//БЛОК СООБЩЕНИЙ Проверяем переменную $_GET['mess']
switch($_GET['mess']){
    case '1':
        echo '<p class="good">Модель удалена !!!</p>';
        break;
    case '2':
        echo '<p class="good">Корзина очищена !!!</p>';
        break;
}
?>
<br /><a href="prod_list.php?id=<?php echo $_GET['back']; ?>">&lt;&lt;&lt; Продолжить покупку</a>
<?php
//конечные тэги + закрытие сессии + закрываем соеденение с БД
include 'inc/bottom.php';
?>