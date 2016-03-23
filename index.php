<?php
//Установка кодировки, соеденение с БД, старт сессии
include 'inc/charset_dbc_sess_s.php';
//Шапка сайта (Доктайп  и т.д.)
$title = 'Интернет Магазин Инструмента';
include 'inc/site_head.php';
?>
<div align="center">САМЫЙ РАЗНЫЙ ИНСТРУМЕНТ<img alt="logo" src="images/tools.jpg" title="Логотип фирмы рога и копыто" width="120" /></div>
<hr />
<table cellpadding="20" width="100%" border="0">
    <tr><td width="10%" valign="top">
            <table width="100%" border="0">
                <tr><td><b>Производитель</b></td></tr>
                <?php
                //Извлекаем данные при помощи цикла foreach из массива объектов
                foreach (Category::find($obj_conn->get_connection()) as $obj_category){
                    echo '<tr><td><a href="prod_list.php?id='.$obj_category->getId().'">'.$obj_category->getName().'</a></td></tr>';
                }
                ?>
            </table>
        </td>
    <td width="90%" valign="top">
        <table border="0" width="100%">
        <tr><td><b>Добро пожаловать к нам в магазин!!!</b></td></tr>
        </table>
    </td></tr>

</table>
<div align="center">
    <hr />
        <p>
        Наши контакты: Страна, город, телефона,<br />
        </p>
    <hr />
</div>
<?php
//конечные тэги + закрытие сессии + закрываем соеденение с БД
include 'inc/bottom.php';
?>