<?php
class User {
    public static function find ($dbc, $login, $pass){
        if (!empty($login) && !empty($pass)) {
            $query = "SELECT * FROM user WHERE login='" . $login . "' AND pass='" . $pass . "'";
            $result = mysqli_query($dbc, $query);
            if (mysqli_num_rows($result) == 1) {
                //Произошел успешный вход
                //Присваиваем переменным сессии значения
                $_SESSION['logged'] = $login;
                return $_SESSION['logged'];
            } else {//Вход не выполнен - неправильный логин или пароль
                echo '<p style="color: red">Неправильный Логин или Пароль.<br /><a href="login.php">Попробовать еще раз</a></p>';
            }
        } else {
            //не все поля заполнены
            echo '<p style="color: red">Поле Логин или Пароль не заполнено.<br /><a href="login.php">Попробовать еще раз</a></p>';
        }
    }
}