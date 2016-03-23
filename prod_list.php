<?php
//Установка кодировки, соеденение с БД, старт сессии
include 'inc/charset_dbc_sess_s.php';
//Шапка сайта (Доктайп  и т.д.)
$title = 'Интернет Магазин Инструмента';
include 'inc/site_head.php';
?>
<div align="center">САМЫЙ РАЗНЫЙ ИНСТРУМЕНТ<img alt="logo" src="images/tools.jpg" title="Логотип фирмы рога и копыто" width="120" /></div>
<hr />
<table cellpadding="20" border="0" width="100%">
    <tr><td width="10%" valign="top">
            <table border="0" width="100%">
                <tr><td><b>Производитель</b></td></tr>
                <?php
                //Извлекаем данные при помощи цикла foreach из массива объектов
                foreach (Category::find($obj_conn->get_connection()) as $obj_category){
                    echo '<tr><td><a href="prod_list.php?id='.$obj_category->getId().'">'.$obj_category->getName().'</a></td></tr>';
                }
                ?>
            </table>
        </td>
        <td width="30%" valign="top">
            <table border="0" width="50%">
                <tr><td><b>Модель Инструмента</b></td><td><b>Цена</b></td><td align="center"><b>Добавить в Корзину</b></td></tr>
                <?php
                if (is_array(Product::findByCategoryId($obj_conn->get_connection(),$_GET['id']))){
                    foreach (Product::findByCategoryId($obj_conn->get_connection(), $_GET['id']) as $obj_product){
                        echo '<tr><td>'.$obj_product->getName().'</td><td>'.$obj_product->getPrice().'</td><td align="center">
                            <form action="basket.php" method="POST">
                            <input type="hidden" name="id" value="'.$obj_product->getId().'">
                            <input type="hidden" name="category_id" value="'.$obj_product->getCategory_id().'">
                            <input type="image" src="images/basket.jpg" title="Добавить в корзину" />
                            </form>
                        </td></tr>';
                    }
                }
                else {
                    echo '<tr><td style="color: red">Модель отсутствует</td><td style="color: red">Пусто</td><td align="center">-</td></tr>';
                }
                ?>
            </table>
        </td></tr>

</table>

<a href="index.php">&lt;&lt;&lt; Назад на Главную страницу</a>
<br /><a href="basket.php">&gt;&gt;&gt; В корзину</a>
<div align="center">
    <hr />
    <p>
        Наши контакты: Страна, город, телефона<br />
    </p>
    <hr />
</div>
<?php
//конечные тэги + закрытие сессии + закрываем соеденение с БД
include 'inc/bottom.php';
?>