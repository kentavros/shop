<?php
//Кодировка, соединение с БД, старт сессии
include 'inc/charset_dbc_sess_s.php';
//Проверка существования сессии - если нет то не грузить страницу а перейти на login.php
if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
}
//Создание массива для функции
$tools = array('id'=>'', 'name'=>'', 'price'=>'', 'category_id'=>$_GET['category_id']);
//Создание функции-форма с параметрами
function form_add($tools, $title_form='Введите модель инструмента и цену', $button='Добавить') {
    echo '<form method="post" action="">
    <fieldset><legend><strong>'.$title_form.'</strong></legend>
    <table>
        <tr><td><label for="name">Название инструмента: </label></td>
        <td><input type="text" id="name" name="name" value="'.$tools['name'].'" /></td></tr>
        <tr><td><label for="price">Цена:</label></td>
        <td><input type="text" id="price" name="price" value="'.$tools['price'].'" /></td></tr>
        <tr><td><input type="hidden" name="id" value="'.$tools['id'].'" />
        <input type="hidden" name="category_id" value="'.$tools['category_id'].'" /></td>
        <td><input type="submit" name="submit" value="'.$button.'" /></td></tr>
    </table>
    </fieldset></form>';
}
//Если не было $_SERVER['REQUEST_METHOD'] == 'POST' - то фактически форма запущена через URL т.е. первый запуск
//но если есть action выполняем блок else
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     ПРОВЕРКА  ВВЕДЕННЫХ ДАННЫХ - ПУСТЫЕ ПОЛЯ - если не пусты то действие...
    if (!empty($_POST['name']) && !empty($_POST['price'])) {
// Если форма послана и id инструмента пуст - то происходит добавление
        if (empty($_POST['id'])) {
// Проверяем, а нет ли такого имяни уже в таблице?
            $query = "SELECT * FROM tools WHERE name='" . $_POST['name'] . "'";
            $result = mysqli_query($obj_conn -> get_connection(), $query);
            if (mysqli_num_rows($result) == 0) {
// Такого имяни нет - добавляем в таблицу баз данных новое имя
                $query = "INSERT INTO tools (name, price, category_id) VALUES ('" . $_POST['name'] . "', '" . $_POST['price'] . "', '" . $_POST['category_id'] . "')";
                $result = mysqli_query($obj_conn -> get_connection(), $query);
//ищем добавленный инструмент и его id для передачи в сообщение
                $query = "SELECT * FROM tools WHERE name='" . $_POST['name'] . "'";
                $result = mysqli_query($obj_conn -> get_connection(), $query);
                $row = mysqli_fetch_array($result);
                header('Location: edit_tools.php?id=' . $row['id'] . '&message=2');
            }
            else {//Такое имя уже есть - !!!
                header('Location: edit_tools.php?category_id=' . $_POST['category_id'] . '&message=3');
            }
        }
        else {//ЕСЛИ НЕ ПУСТ id ИНСТРУМЕНТА значит редактирование модели или цены
            $query = "UPDATE tools SET name='".$_POST['name']."', price='".$_POST['price']."' WHERE id='".$_POST['id']."'";
            $result = mysqli_query($obj_conn -> get_connection(), $query);
            header('Location: edit_tools.php?id='.$_POST['id'].'&message=6');
        }
    }
    else {// ПОЛЯ ПУСТЫ!!! или ИМЯ или Цена!
        header('Location: edit_tools.php?category_id='.$_POST['category_id'].'&message=4');
    }
}
else {
    //При помощи SWITCH проверяем action - в зависимости от значения выкидываем сообщения и отображение формы на странице
    //ОТОБРАЖЕНИЕ, РЕДАКТИРОВАНИЕ, УдалениЕ
    switch ($_GET['action']) {
        case 1://выбрана категория - отображаем модели выбранной категории
            header('Location: edit_tools.php?category_id='.$_GET['category_id'].'&message=1');
            break;
        case 2://выбрано ИЗМЕНИТЬ получаем персональное id инструмента для редактирования
            header('Location: edit_tools.php?id='.$_GET['id'].'&message=5');
            break;
        case 3://Удаление инструмента - прежде чем удалить вынимаем idкатегории чтоб отображалась талица нижняя после удаления
            $query ="SELECT * FROM tools WHERE id='".$_GET['id']."'";
            $result = mysqli_query($obj_conn -> get_connection(),$query);
            $row = mysqli_fetch_array($result);
            header('Location: edit_tools.php?id='.$_GET['id'].'&category_id='.$row['category_id'].'&message=7');
            break;
        case 4://Убиваем сессию и идем на страничку Login.php
            $_SESSION=array();
            header('Location: login.php');
            break;
    }
}


//Шапка сайта (Доктайп  и т.д.)
$title = 'Панель управления МАГАЗИНОМ';
include 'inc/site_head.php';
?>
<!-- Основная область Начало -->
<strong>Панель управления МАГАЗИНОМ</strong><br />
<p style="color: green">Вы зашли как: &quot;<?php echo $_SESSION['logged'].'&quot; <a href="edit_tools.php?action=4">(Выход)</a>'; ?></p>
<hr color="orange" size="4" />
<?php
//Конструкцией switch выводим данные в зависимости от значения message:
switch ($_GET['message']) {
    case 1://выбрана категория - отображаем модели выбранной категории
        $query = "SELECT * FROM categories WHERE id='".$_GET['category_id']."'";
        $result = mysqli_query($obj_conn -> get_connection(), $query);
        $row = mysqli_fetch_array($result);
        form_add($tools);
        echo '<p class="categories">Внести информацию в &quot;'.$row['name'].'&quot;.</p>';
        break;
    case 2://инструмент добавлен успешно
        $query = "SELECT * FROM tools WHERE id='".$_GET['id']."'";
        $result = mysqli_query($obj_conn -> get_connection(), $query);
        $row = mysqli_fetch_array($result);
// Вынимаем имя Производителя
        $query2 ="SELECT * FROM categories WHERE id='".$row['category_id']."'";
        $result2 = mysqli_query($obj_conn -> get_connection(), $query2);
        $row2 = mysqli_fetch_array($result2);
        $tools['category_id'] = $row['category_id'];
        form_add($tools);
        echo '<p class="categories">Внести информацию в &quot;'.$row2['name'].'&quot;.</p>';
        echo '<p class="good">Модель &quot;'.$row['name'].'&quot; добавлена, цена: &quot;'.$row['price'].' грн.&quot;</p>';
        break;
    case 3://Такое имя уже есть - попробуйте еще раз
        $query = "SELECT * FROM categories WHERE id='".$_GET['category_id']."'";
        $result = mysqli_query($obj_conn -> get_connection(), $query);
        $row = mysqli_fetch_array($result);
        form_add($tools);
        echo '<p class="categories">Внести информацию в &quot;'.$row['name'].'&quot;.</p>';
        echo '<p class="error">Такая модель уже существует - попробуйте еще раз!</p>';
        break;
    case 4://Имя или цена не введены - попробуйте еще раз.
        $query = "SELECT * FROM categories WHERE id='".$_GET['category_id']."'";
        $result = mysqli_query($obj_conn -> get_connection(), $query);
        $row = mysqli_fetch_array($result);
        form_add($tools);
        echo '<p class="categories">Внести информацию в &quot;'.$row['name'].'&quot;.</p>';
        echo '<p class="error">Поле &quot;название&quot; или &quot;цена&quot; не заполнено! Попробуйте еще раз!</p>';
        break;
    case 5://Изменение модели инструмента имея id инструмента
        $query = "SELECT * FROM tools WHERE id='".$_GET['id']."'";
        $result = mysqli_query($obj_conn -> get_connection(), $query);
        $row = mysqli_fetch_array($result);
        $tools['id'] = $row['id'];
        $tools['name'] = $row['name'];
        $tools['price'] = $row['price'];
        $tools['category_id'] = $row['category_id'];
// Вынимаем имя Производителя
        $query2 ="SELECT * FROM categories WHERE id='".$row['category_id']."'";
        $result2 = mysqli_query($obj_conn -> get_connection(), $query2);
        $row2 = mysqli_fetch_array($result2);
        form_add($tools, 'Изменить модель инструмента', 'Изменить');
        echo '<p class="categories">Изменяем модель инструмента: &quot;'.$tools['name'].'&quot;<br />
        Цена: &quot;'.$tools['price'].'&quot; грн.<br />
        Вносим изменения в группу: &quot;'.$row2['name'].'&quot;.</p>';
        break;
    case 6: //Успешно отредактировано -  берем id показываем новое имя и вносим в ворму category_id
        $query = "SELECT * FROM tools WHERE id='".$_GET['id']."'";
        $result = mysqli_query($obj_conn -> get_connection(), $query);
        $row = mysqli_fetch_array($result);
        $tools['category_id'] = $row['category_id'];
        form_add($tools);
        // Вынимаем имя Производителя
        $query2 ="SELECT * FROM categories WHERE id='".$row['category_id']."'";
        $result2 = mysqli_query($obj_conn -> get_connection(), $query2);
        $row2 = mysqli_fetch_array($result2);
        echo '<p class="good">Модель изменена на &quot;'.$row['name'].'&quot;, цена: &quot;'.$row['price'].' грн.&quot;</p>';
        echo '<p class="categories">Внести информацию в &quot;'.$row2['name'].'&quot;.</p>';
        break;
    case 7://Удаляем модель инструмента
        //Вынимаю имя по id для дольнейшего его передачи гетом чтоб вывести его в сообщении о успешном удалении.
        $query ="SELECT * FROM tools WHERE id='".$_GET['id']."'";
        $result = mysqli_query($obj_conn -> get_connection(),$query);
        $row = mysqli_fetch_array($result);
        $tools['category_id'] = $row['category_id'];
        form_add($tools);
        $del_name = $row['name'];
        $query = "DELETE FROM tools WHERE id='".$_GET['id']."'";
        mysqli_query($obj_conn -> get_connection(), $query);
        $query2 ="SELECT * FROM categories WHERE id='".$tools['category_id']."'";
        $result2 = mysqli_query($obj_conn -> get_connection(), $query2);
        $row2 = mysqli_fetch_array($result2);
        echo '<p class="good">Модель &quot;'.$del_name.'&quot; удалена.</p>';
        echo '<p class="categories">Внести информацию в &quot;'.$row2['name'].'&quot;.</p>';
        break;
    default://Не выбрана категория-производитель
        form_add($tools);
        echo '<p class="categories">Выберите производителя из списка!</p>';
}
?>
<!-- Вывод таблицы с моделями инструментов из двух таблиц базы данных - categories & tools -->
<table border="0" width="60%" cellpadding="10">
        <tr><td width="15%" valign="top">
                <table border="1px" width="100%" cellpadding="1">
                    <tr><td><strong>Производитель</strong></td></tr>
                    <?php //Выводим из таблицы 1(categories) БД Производителей
                    foreach (Category::find($obj_conn->get_connection()) as $obj_category){
                        echo '<tr><td><a href="edit_tools.php?category_id='.$obj_category->getId().'&action=1">'.$obj_category->getName().'</a></td></tr>';
                    }
                    ?>
                    </td></table>
            <td width="45%" valign="top">
                <table width="100%" border="0" cellpadding="1">
                    <tr><td><strong>Модель Инструмента</strong></td><td><strong>Цена</strong></td><td><strong>Изменить/Удалить</strong></td></tr>
                    <?php
                    //Выводим из таблицы 2 (tools) модели инструмента и цену
                    //Если есть $_GET['category_id'] через неё если нет то через персональный id
                    if (isset($_GET['category_id'])){
                        if (is_array(Product::findByCategoryId($obj_conn->get_connection(), $_GET['category_id']))){
                        foreach (Product::findByCategoryId($obj_conn->get_connection(), $_GET['category_id']) as $obj_product) {
                            echo '<tr><td>' . $obj_product->getName() . '</td><td>' . $obj_product->getPrice() . ' грн.</td>
                        <td><a href="edit_tools.php?id=' . $obj_product->getId() . '&action=2">Изменить</a>
                        / <a href="edit_tools.php?id=' . $obj_product->getId() . '&action=3">Удалить</a></td></tr>';
                        }
                    }
                        else {
                            echo '<tr><td style="color: red">Модель отсутствует</td><td style="color: red">Пусто</td></tr>';
                        }
                    }
                    else {
                        //Этот код работает когда ты выбираешь "Изменить" и переходишь на персональный ID
                        // иначе пустые поля продуктов на странице
                        $category_id = Product::findById($obj_conn->get_connection(), $_GET['id'])->getCategory_id();
                        if (is_array(Product::findByCategoryId($obj_conn->get_connection(), $category_id))){
                            foreach (Product::findByCategoryId($obj_conn->get_connection(), $category_id) as $obj_product) {
                                echo '<tr><td>' . $obj_product->getName() . '</td><td>' . $obj_product->getPrice() . ' грн.</td>
                        <td><a href="edit_tools.php?id=' . $obj_product->getId() . '&action=2">Изменить</a>
                        / <a href="edit_tools.php?id=' . $obj_product->getId() . '&action=3">Удалить</a></td></tr>';
                            }
                        }
                        else {
                            echo '<tr><td style="color: red">Модель отсутствует</td><td style="color: red">Пусто</td></tr>';
                        }
                    }
                    ?>
                </table></td></tr>
</table>
<hr color="orange" size="4" />
<a href="edit_categories.php">&lt;&lt;&lt; Вернуться к списку производителей</a>
<!-- Основная область Конец -->
<?php
//конечные тэги + закрытие сессии + закрываем соеденение с БД
include 'inc/bottom.php';
?>