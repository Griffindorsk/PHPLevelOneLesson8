<?php
session_start();
//разрешает показать форму авторизации админа, если пользователь ввел верную ссылку и администратор еще не авторизован
if (isset($_GET['6460ae4c4d68b']) && htmlspecialchars($_GET['6460ae4c4d68b']) === 'x60ae4c4d68b342' && !isset($_SESSION['manager_id'])) $admin_form = true;

//запускает процесс авторизации админа
if (isset($_POST['admin_submit']) && strip_tags($_POST['admin_name']) <>'' && strip_tags($_POST['admin_pass']) <>'') {
$admin_name_to_check = strip_tags($_POST['admin_name']);
$admin_pass_to_check = strip_tags($_POST['admin_pass']);
}

//удаляет cookies и идентификатор сессии при выходе админа
if (isset($_GET['admin_logout']) && isset($_SESSION['manager_id']) && isset($_SESSION['manager'])) {
    unset($_SESSION['manager_id']);
    unset($_SESSION['manager']);
    session_destroy();
}

if (isset($_GET['cat_volume'])) {//запрос админа на генерацию каталога
    ($_GET['cat_volume'] <> '') ? $number_of_items = (int)htmlspecialchars($_GET['cat_volume']) : $number_of_items = '';
}
if (isset($_GET['clean'])) {//запрос админа на удаление каталога
    ($_GET['clean'] <> '') ? $cleaning = htmlspecialchars($_GET['clean']) : $cleaning = '';
}

if (isset($_GET['show'])) {//запрос описания конкретного товара
    ($_GET['show'] <> '') ? $show = htmlspecialchars($_GET['show']) : $show = '';
}

//обработка запроса на вход или регистрацию пользователя
if (isset($_POST['new_customer_ok'])) {
    $temp_customer_name = htmlspecialchars($_POST['new_customer_name']);
    $temp_customer_password = htmlspecialchars($_POST['new_customer_password']);
}

//удаляет cookies и идентификатор сессии при выходе пользователя
if (isset($_GET['user_logout']) && isset($_SESSION['username']) && isset($_SESSION['user_hash_id'])) {
    unset($_SESSION['username']);
    unset($_SESSION['user_hash_id']);
    session_destroy();
    unset($user_hash_id);
}

if (isset($_GET['to_basket'])) {//запрос на добавление товара в корзину
    ($_GET['to_basket'] <> '') ? $product_selected = htmlspecialchars($_GET['to_basket']) : $product_selected = '';
}
if (isset($_GET['item_del'])) {//запрос пользователя на удаление конкретной позиции в корзине
    ($_GET['item_del'] <> '') ? $item_del = htmlspecialchars($_GET['item_del']) : $item_del = '';
    if (isset($_GET['customer_del']) && isset($_GET['order_id'])) {//запрос админа на удаление конкретной позиции в общем списке заказов
    $customer_id_del = htmlspecialchars($_GET['customer_del']);
    $order_id_del = htmlspecialchars($_GET['order_id']);
}
}

//запрос пользователя на полную очистку корзины товаров
if (isset($_GET['clean_basket']) && $_GET['clean_basket'] <> '') {
    $clean_basket = htmlspecialchars($_GET['clean_basket']);
} else $clean_basket = '';

//запрос пользователя на оформление заказа
(isset($_GET['order_basket']) && htmlspecialchars($_GET['order_basket']) == 'make') ? $order = true : $order = false;

//запрос пользователя на просмотр всех заказов
if (isset($_GET['your_orders']) && htmlspecialchars($_GET['your_orders']) == 'show') {
    $show_orders = true;
}

//запрос админа на просмотр всех заказов
if (isset($_GET['all_orders']) && htmlspecialchars($_GET['all_orders']) == 'show') {
    $admin_show_orders = true;
}

require "../core/model.php";