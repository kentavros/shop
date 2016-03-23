<?php
//Кодировка, соединение с БД, старт сессии
include 'inc/charset_dbc_sess_s.php';
//Проверка существования сессии - если нет то не грузить страницу а перейти на login.php
if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
}
//Создаем массив
$category = array('id'=>$_POST['id'], 'name'=>'');
//Создание функции_форма у которой параметр массив и 2 по умолчанию имеют значения
function form_add($category, $title_form='Управление категориями', $button='Добавить') {
    echo '
    <form method="POST" action="">
    <fieldset><legend><strong>'.$title_form.'</strong></legend>
    <table>
    <tr><td>
    <label for="name">Название: </label>
    </td>
    <td>
    <input type="text" id="name" name="name" value="'.$category['name'].'"/>
    </td></tr>
    <tr><td></td><td>
    <input type="hidden" name="id" value="'.$category['id'].'" />
    <input type="submit" name="submit" value="'.$button.'" />
    </td></tr></table>
    </fieldset>
    </form>';
}
//Если не было $_SERVER['REQUEST_METHOD'] == 'POST' - то первый запуск
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
// Если форма послана и id пуст - то происходит добавление
    if (empty($_POST['id'])) {
        // Проверяем, а нет ли такого имяни уже в таблице?
        if (!Category::categoryExist($obj_conn->get_connection(), $_POST['name'])){
            //Если false - значит такой категории нет - добавляем в таблицу баз данных новое имя
            Category::addCategory($obj_conn->get_connection(), $_POST['name']);
            // Теперь вынимаем id добавленного товара и помещаем его в переменную id для удобства, не более
            $id = Category::findByName($obj_conn->get_connection(), $_POST['name'])->getId();
            header('Location: edit_categories.php?id='.$id.'&message=1');
        } else {
            //Если true - значит такая категория уже существует
            //предложить ввести другое
            //заносим в переменную $id длинный кусок кода для удобства.
            $id = Category::findByName($obj_conn->get_connection(), $_POST['name'])->getId();
            header('Location: edit_categories.php?id='.$id.'&message=2');
        }
    }
    else {
// А если $_POST['id'] не пуста, значит у нас редактирование существующих данных
        if (Category::updateCategory($obj_conn->get_connection(), $_POST['id'], $_POST['name'])){
            header('Location: edit_categories.php?id='.$_POST['id'].'&message=5');
        } else {echo 'Ошибка редактирования категории';}
    }
}
else { //ЕСли нет POST, Но есть action - делаем действия Удалить / Изменить
    switch ($_GET['action']) {
        case '3':// Удаляем данные из таблицы categories
            if (Category::deleteCategory($obj_conn->get_connection(), $_GET['id'])){
                header('Location: edit_categories.php?message=3');
            }
            else {
                echo 'Ошибка, Не удалено'; }
            break;
        case '2':// Редактируем данные в таблице categories
            header('Location: edit_categories.php?id='.$_GET['id'].'&message=4');
            break;
        case '4'://Убиваем сессию и идем на страничку Login.php
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
<hr color="red" size="4" />
<?php
//Конструкцией switch выводим данные в зависимости от значения message:
switch ($_GET['message']) {
    //1.-Производитель добавлен
    case '1':
        $name = Category::findById($obj_conn->get_connection(), $_GET['id'])->getName();
        form_add($category);
        echo '<p class="categories">Добавьте категорию</p>';
        echo '<p class="good">Производитель &quot;'.$name.'&quot; успешно добавлен!</p>';
        break;
    //2.-Такой производитель уже есть.
    case '2':
        $name = Category::findById($obj_conn->get_connection(), $_GET['id'])->getName();
        form_add($category);
        echo '<p class="categories">Добавьте категорию</p>';
        echo '<p class="error">Производитель &quot;'.$name.'&quot; уже есть - попробуйте еще раз</p>';
        break;
    //3.-Удаляем производителя
    case '3':
        form_add($category);
        echo '<p class="categories">Добавьте категорию</p>';
        echo '<p class="good">Производитель успешно удален!</p>';
        break;
    //4.-Редактирование производителей Фаза1
    case '4':
        $category['id'] = Category::findById($obj_conn->get_connection(), $_GET['id'])->getId();
        $category['name'] = Category::findById($obj_conn->get_connection(), $_GET['id'])->getName();
        form_add($category, 'Отредактировать категорию', 'Изменить');
        echo '<p class="categories">Изменить категорию &quot;'.$category['name'].'&quot;</p>';
        break;
    //5.-Редактирование производителей Фаза2 - успешно отредактировано
    case '5':
        //Выводим имя объекта и для удобства сохраняем в переменую длинный несуразный код
        $name = Category::findById($obj_conn->get_connection(), $_GET['id'])->getName();
        form_add($category);
        echo '<p class="categories">Добавьте категорию</p>';
        echo '<p class="good">Производитель успешно изменен на &quot;'.$name.'&quot;!</p>';
        break;
//    отображаем форму ввода производителей
    default:
        form_add($category);
        echo '<p class="categories">Добавьте категорию</p>';
}
?>
<!-- Вывод таблицы производителей с кнопками редактировать и удалить -->
<table border="1px" cellpadding="2">
    <tr><th>Производитель</th><th>Изменить / Удалить</th></tr>
    <?php
    //Получаем категории из объектов (точней из класса Category)
    //Извлекаем данные при помощи цикла foreach из массива объектов
    foreach (Category::find($obj_conn->get_connection()) as $obj_category){
        echo '<tr><td><a href="edit_tools.php?category_id='.$obj_category->getId().'&action=1">'.$obj_category->getName().'</a></td>
            <td><a href="edit_categories.php?id='.$obj_category->getId().'&action=2">Изменить</a>
             / <a href="edit_categories.php?id='.$obj_category->getId().'&action=3">Удалить</a></td></tr>';
    }
    ?>
</table>
<!-- Основная область Конец -->
<?php
//конечные тэги + закрытие сессии + закрываем соеденение с БД
include 'inc/bottom.php';
?>