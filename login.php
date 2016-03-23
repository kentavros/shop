<?php
//Кодировка, соединение с БД, старт сессии
include 'inc/charset_dbc_sess_s.php';
//Проверяем послана ли форма? если НЕТ грузим форму ввода Логина и Пароля.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Обрезаем теги и пробели по концам в данных полученных с формы
    $login = trim(strip_tags($_POST['login']));
    $pass = sha1(trim(strip_tags($_POST['pass'])));
    User::find($obj_conn->get_connection(), $login, $pass);
    if ($_SESSION['logged']){
        header('Location: edit_categories.php');
    }
}
else {//Форма не сабмитилась - вывод формы
//Форма логина
    echo '
    <form method="POST" action="">
    <fieldset><legend><strong>Введите Логин и пароль</strong></legend>
    <table>
    <tr><td><label for="login">Логин: </label></td>
    <td><input type="text" id="login" name="login" value=""/></td></tr>
    <tr><td><label for="pass">Пароль: </label></td>
    <td><input type="password" id="pass" name="pass" value=""/></td></tr>
    <tr><td></td><td><input type="submit" name="submit" value="ОК" /></td></tr>
    </table>
    </fieldset>
    </form>';
}
//Закрываем соединение
$obj_conn->db_close();
?>