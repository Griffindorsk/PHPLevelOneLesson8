<?php
require_once "../core/functions.php";

session_start();

//форма для авторизации админа
$admin_form_html = <<<_END
    <form class="initial_form" action="#" method="POST">
        <input class="text_field" type="text" name="admin_name" placeholder="ваше имя">
        <input class="text_field" type="password" name="admin_pass" placeholder="пароль">
        <input class="auth_button" type="submit" name="admin_submit" value="Подтвердить">
    </form>
_END;

//вывод формы для авторизации админа
if (isset($admin_form)) echo $admin_form_html;

//авторизация админа (начало)
$alert = '';
if (isset($admin_name_to_check) && isset($admin_pass_to_check)) {
    $result = sql_request("SELECT `title`, `pass_hash`, `id_hash` FROM `managers` WHERE manager_name=\"$admin_name_to_check\"");
    if ($result != 'empty_table' && $result !== false) {//если логин найден в базе админов
        $pass_hash = $result[0]['pass_hash'];//хэш пароля пользователя из базы админов
        $title = $result[0]['title'];//уровень доступа пользователя из базы админов
        $id_hash = $result[0]['id_hash'];//хэш пользователя из базы админов
        unset($result);
        if ($title == 'admin' && password_verify($admin_pass_to_check,$pass_hash)) {
            if (isset($_SESSION['username'])) unset($_SESSION['username']);
            if (isset($_SESSION['user_hash_id'])) unset($_SESSION['user_hash_id']);
            $_SESSION['manager'] = $admin_name_to_check;
            $_SESSION['manager_id'] = $id_hash;
        } else {
            $alert = "у вас недостаточно прав или вы ввели неверный пароль";
        }
        unset($pass_hash);
        unset($title);
        unset($id_hash);
    } else {
        $alert = "неверное имя пользователя";
    }
    unset($result);
    echo "<p>{$alert}</p>";
}
//авторизация админа (конец)

//Проверка режима администрирования (начало)
if (isset($_SESSION['manager_id']) && isset($_SESSION['manager'])) {
    $admin_name = $_SESSION['manager'];
    $admin_id_hash = $_SESSION['manager_id'];
    $result = sql_request("SELECT `id_hash` FROM `managers` WHERE manager_name=\"$admin_name\"");
    if ($result[0]['id_hash'] === $admin_id_hash) {
        //$admin_notice выводит сообщение, что пользователь в режиме администирования в верхней части страницы
        $admin_notice = "<p>Ваш логин: {$admin_name}. Режим администрирования.<a href=?admin_logout> Выход из режима администрирования.</a></p>";
        //$admin_controls предоставляет html код для управляющих кнопок каталога
        $admin_controls = <<<_END
        <div class="control">
            <form class="form_arrangement" action="index.php">
                <label for="generation_value">Сколько товаров добавить в каталог:</label>
                <input name="cat_volume" id="generation_value" type="number" min="1" max="30" placeholder="кол-во позиций">
                <button type="submit">добавить в каталог</button>
            </form>
            <p class="button"><a href="index.php?clean=full&cat_volume=">удалить каталог</a></p>
            <p class="button"><a href="index.php?all_orders=show" target="_blank">Посмотреть все заказы</a></p>
        </div>
_END;
    }
    unset($result);
} else {
        $admin_notice = '';
        $admin_controls = '';
    }
//Проверка режима администрирования (конец)

//вывод каталога на экран
if (!isset($full_list)) $full_list = catalogue_show();

//проверка ввода при генерации каталога товаров
if (isset($number_of_items) && $number_of_items == '' && (!isset($cleaning) || $cleaning == '')) {
    $control_message = 'необходимо задать кол-во позиций';
} else $control_message = '';

//проверка ввода и генерация каталога товаров
if (isset($number_of_items) && $number_of_items <> '') {
    $control_message = '';
    catalogue($number_of_items);//генерация каталога товаров из случайного набора параметров
    $full_list = catalogue_show();//вывод каталога на экран
}

//полное удаление всех товаров из каталога
if (isset($cleaning) && $cleaning == 'full') {
    sql_request("DELETE FROM catalogue WHERE id>0");
    $full_list = catalogue_show();//вывод каталога на экран
}

//вывод описания товара
if (isset($show) && $show <> '') {
    $product_description = show_description($show);
    $text_description = $product_description[0];
    $path = $product_description[1];
    $product_photo = <<<_END
    <img class="product_photo" src="../$path$product_description[2]" alt="фотография футболки">
_END;
    } else {
        $product_description = show_description('nothing');
        $text_description = $product_description[0];
        $product_photo = $product_description[1];
}

//Обработка входа пользователя. Если пользователь уже есть в базе, то проверка хэша пароля пользователя. Если пользователя нет, тогда внесение нового пользователя в базу без каких-либо доп.проверок. Установка идентификаторов сессии.
if (isset($temp_customer_name) && $temp_customer_name <>'' && isset($temp_customer_password) && $temp_customer_password <>'') {
    $result = sql_request("SELECT `customer_id`,`customer_name`, `pass_hash`, `id_hash` FROM `customers` WHERE customer_name=\"$temp_customer_name\"");
    if ($result == 'empty_table') {
        $pass_hash = password_hash($temp_customer_password, PASSWORD_DEFAULT);
        $id_hash = uniqid(random_int(10000,99999), true);
        sql_request("INSERT INTO `customers` (`customer_id`, `customer_name`, `pass_hash`, `id_hash`) VALUES (NULL,'$temp_customer_name','$pass_hash','$id_hash')");
        $result = sql_request("SELECT `customer_id`,`customer_name`, `pass_hash`, `id_hash` FROM `customers` WHERE customer_name=\"$temp_customer_name\"");
        if (isset($_SESSION['manager'])) unset ($_SESSION['manager']);
        if (isset($_SESSION['manager_id'])) unset ($_SESSION['manager_id']);
        $_SESSION['username'] = $temp_customer_name;
        $_SESSION['user_hash_id'] = $result[0]['id_hash'];
        echo "<p>" . $_SESSION['username'] . ", спасибо, что зарегистировались!</p>";
    } elseif ($result <> 'false' && password_verify($temp_customer_password, $result[0]['pass_hash'])) {
        if (isset($_SESSION['manager'])) unset ($_SESSION['manager']);
        if (isset($_SESSION['manager_id'])) unset ($_SESSION['manager_id']);
        $_SESSION['username'] = $temp_customer_name;
        $_SESSION['user_hash_id'] = $result[0]['id_hash'];
        echo "<p>" . $_SESSION['username'] . ", спасибо, что вы по-прежнему с нами!</p>";
        //$user_logged_as = $temp_customer_name;
    }
    //$user_logged_as = $temp_customer_name;
    // $display_exit = '';//появляется кнопка Выйти
    // $display_form = 'none';//форма входа/регистрации исчезает
    unset($result);
} else {
    // $user_logged_as = '';
    // $display_exit = 'none';//кнопка Выйти скрыта
    // $display_form = '';//выведена форма входа/регистрации
}

if (isset($_SESSION['username'])) {
    $user_logged_as = $_SESSION['username'];
    $display_exit = '';//кнопка Выйти выведена
    $display_form = 'none';//форма входа/регистрации исчезает
} else {
    $user_logged_as = '';
    $display_exit = 'none';//кнопка Выйти скрыта
    $display_form = '';//выведена форма входа/регистрации
}

// //действия для незарегистрированного пользователя
// if (!isset($_SESSION['username']) && !isset($_SESSION['temp_user_hash'])) {//для работы с незарегистрированным пользователем делаем хэш-идентификатор и записываем выбранные товары во временную корзину с этим идентификатором
//     $_SESSION['temp_user_hash'] = uniqid(random_int(10000,99999), true);
//     $temp_user_hash_id = $_SESSION['temp_user_hash'];
// } elseif (!isset($_SESSION['username'])) {
//     $temp_user_hash_id = $_SESSION['temp_user_hash'];
// }

//делаем хэш-идентификатор и записываем выбранные товары во временную корзину с этим идентификатором
if (!isset($_SESSION['temp_user_hash'])) {
    $_SESSION['temp_user_hash'] = uniqid(random_int(10000,99999), true);
}
$temp_user_hash_id = $_SESSION['temp_user_hash'];

// if (!isset($_SESSION['username'])) {
    if (!isset($basket_list)) {//показ выбранных, но не оформленных товаров в корзине
        $basket_view = basket_show("temp_basket", $temp_user_hash_id);
        $basket_list = $basket_view[0];
        $total_sum = $basket_view[1];
    }
    if (isset($clean_basket) && $clean_basket == 'full') {//полное удаление всех товаров из корзины
        sql_request("DELETE FROM temp_basket WHERE id_basket>0 AND temp_hash=\"$temp_user_hash_id\"");
        $basket_view = basket_show("temp_basket", $temp_user_hash_id);//обновление вида корзины после удаления выбранных товаров
        $basket_list = $basket_view[0];
        $total_sum = $basket_view[1];
    }
    if (isset($item_del) && $item_del <> '' && !isset($customer_id_del)) {//удаление выбранного товара из корзины
        sql_request("DELETE FROM temp_basket WHERE id_basket=$item_del AND temp_hash=\"$temp_user_hash_id\"");
        $basket_view = basket_show("temp_basket", $temp_user_hash_id);//обновление вида корзины после удаления выбранных товаров
        $basket_list = $basket_view[0];
        $total_sum = $basket_view[1];
        unset($item_del);
    }

    //удаление админом товара из заказа покупателя
    if (isset($item_del) && isset($customer_id_del) && isset($order_id_del)) {
        sql_request("DELETE FROM basket WHERE id_basket=$item_del AND id_customer=\"$customer_id_del\" AND order_number=\"$order_id_del\"");
        $orders_view = admin_orders_show();//обновление списка товаров
        $orders_list = $orders_view[0];
        $orders_sum = $orders_view[1];
        require "../core/view_orders_admin.php";
        die();
    }

    if (isset($product_selected) && $product_selected <>'') {//запрос на добавление товара в корзину
        put_in_basket("temp_basket", "unknown", "unknown", $temp_user_hash_id, $product_selected);
        $basket_view = basket_show("temp_basket", $temp_user_hash_id);
        $basket_list = $basket_view[0];
        $total_sum = $basket_view[1];
        unset($product_selected);
    }
// }

//действия при запросе на оформление заказа
if (isset($order) && $order === true && !isset($_SESSION['username'])) {
    $control_message = "Необходимо войти в систему или зарегистрироваться!";
}
if (isset($order) && $order === true && isset($_SESSION['username'])) {
    $control_message = order_move($_SESSION['username'], $_SESSION['temp_user_hash']);
}

//действия при запросе Пользователя показать заказы Пользователя
if (isset($show_orders) && $show_orders === true && isset($_SESSION['user_hash_id'])) {
    $orders_view = orders_show($_SESSION['username']);
    $orders_list = $orders_view[0];
    $orders_sum = $orders_view[1];
    unset($orders_view);
    require "../core/view_orders.php";
    die();
}

//действия при запросе Админа показать все заказы
if (isset($admin_show_orders) && $admin_show_orders === true && isset($_SESSION['manager_id'])) {
    $orders_view = admin_orders_show();
    $orders_list = $orders_view[0];
    $orders_sum = $orders_view[1];
    unset($orders_view);
    require "../core/view_orders_admin.php";
    die();
}

require "../core/view.php";