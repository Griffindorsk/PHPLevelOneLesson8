<?php
function catalogue($quantity) {//формирование каталога из заданного кол-ва товаров
    for ($i = 1; $i <= $quantity; $i++) {
        product_generation();
    }
}
function product_generation() {//формирование параметров товара из случайного набора данных
    $pr_number = "A" . rand(10000,99999);
    $pr_name = "футболка";
    $gender = rand(1,777);
    ($gender % 2 == 0) ? $gender = "М": $gender = "Ж";//случайная выборка пола
    $size = (int)(rand(1000, 9999) / 1000);//случайная выборка размера футболки
    switch ($size) {
        case 4:
            $size = 'S';
            break;
        case 5:
            $size = 'M';
            break;
        case 6:
            $size = 'L';
            break;
        case 7:
            $size = 'XL';
            break;
        default:
            if ($size < 4) $size = 'XS';
            if ($size > 7) $size = 'XXL';
    }
    
    $color = rand(1,12);//случайный выбор индекса цвета из 12-ти доступных в базе
    $result = sql_request("SELECT color FROM colors WHERE id_color=$color");
    $color = $result[0]['color'];//получение имени цвета, соответствующего индексу
    
    //находим фотографию, которая соответствует выбранному цвету
    $result = sql_request("SELECT photoname FROM images WHERE color=\"$color\"");
    $photo = $result[0]['photoname'];
    $price = rand(300, 2000);//случайная цена
    $on_stock = rand(0, 50);//случайное кол-во на складе
    $selected = 0;//сколько выбрано для заказа
    $description_index = rand(1,5);//случайная выборка индекса описания

    //добавляем товар в каталог
    sql_request("INSERT INTO `catalogue` (`id`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `price`, `on_stock`, `selected`, `description`) VALUES (NULL,'$pr_number','$pr_name','$gender','$size','$color','$photo','$price','$on_stock','$selected', '$description_index')");   
}
function catalogue_show() {
    $full_list = '';
    $result_cat = sql_request("SELECT id,pr_number,pr_name,gender,size,color,photo,price FROM catalogue WHERE id>0");
    if (gettype($result_cat) == 'array') {
        $row = 1;
        foreach ($result_cat as $row_data) {
            $id = $row_data['id'];
            $pr_number = $row_data['pr_number'];
            $pr_name = $row_data['pr_name'];
            $gender = $row_data['gender'];
            $size = $row_data['size'];
            $color = $row_data['color'];
            $photo = $row_data['photo'];
            $price = $row_data['price'];
            $result_image = sql_request("SELECT iconpath FROM images WHERE photoname=\"$photo\"");
            $path_to_icon = $result_image[0]['iconpath'];
            
            $row = $row + 1;
            $full_list = $full_list . <<<_END
            <div style="grid-area: $row/1" class="items"><a href="index.php?show=$id">$pr_number</a></div>
            <div style="grid-area: $row/2" class="items"><a href="index.php?show=$id">$pr_name</a></div>
            <div style="grid-area: $row/3" class="items"><a href="index.php?show=$id">$gender</a></div>
            <div style="grid-area: $row/4" class="items"><a href="index.php?show=$id">$size</a></div>
            <div style="grid-area: $row/5" class="items"><a href="index.php?show=$id">$color</a></div>
            <div style="grid-area: $row/6" class="items"><a href="index.php?show=$id"><img src="../$path_to_icon$photo" alt="иконка футболки"></a></div>
            <div style="grid-area: $row/7" class="items"><a href="index.php?show=$id">$price</a></div>
            <div style="grid-area: $row/8" class="items col_button"><a href="index.php?to_basket=$id">выбрать</a></div>
_END;
    }
    }
    return $full_list;
}

function show_description($show) {
    if ($show == 'nothing') {
        $product_description = ['','',''];
    } else {
        $result_catalogue = sql_request("SELECT `photo`,`description` FROM catalogue WHERE id=$show");
        $description_index = $result_catalogue[0]['description'];
        $result_descriptions = sql_request("SELECT `description` FROM descriptions WHERE id_description=$description_index");
        $description_text = $result_descriptions[0]['description'];
        $photoname = $result_catalogue[0]['photo']; 
        $images_result = sql_request("SELECT `imagepath` FROM images WHERE photoname=\"$photoname\"");
        $pathtophoto = $images_result[0]['imagepath'];
        $product_description = [$description_text, $pathtophoto, $photoname];
    }
    return $product_description;
}

function order_move($username, $user_hash) {
    $temp_basket_result = sql_request("SELECT `id_basket`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `description`, `price_unit`, `quantity` FROM `temp_basket` WHERE id_basket>0 AND temp_hash=\"$user_hash\"");
    if (gettype($temp_basket_result) == 'array') {
        $order_number = uniqid(random_int(1,9), false);
        $customer = $username;
        foreach ($temp_basket_result as $row_data) {
            $pr_number = $row_data['pr_number'];
            $pr_name = $row_data['pr_name'];
            $gender= $row_data['gender'];
            $size= $row_data['size'];
            $color= $row_data['color'];
            $photo= $row_data['photo'];
            $description_index= $row_data['description'];
            $price_unit= $row_data['price_unit'];
            $quantity= $row_data['quantity'];
            sql_request("INSERT INTO `basket` (`id_basket`, `id_customer`, `order_number`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`,`description`,`price_unit`, `quantity`) VALUES (NULL,'$customer','$order_number','$pr_number','$pr_name','$gender','$size','$color','$photo', '$description_index','$price_unit','$quantity')");
        }
        $control_message = 'Заказ размещен';
    } else {
        $control_message = 'Вы не выбрали ни одного товара';
    }
    return $control_message;
}

//$basket_type определяет, к какой таблице обращаться (basket - корзина заказов; temp_basket - временная до авторизации)
function basket_show($basket_type, $user_hash) {
    $result_basket = sql_request("SELECT `id_basket`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `price_unit`, `quantity` FROM `$basket_type` WHERE id_basket>0 AND temp_hash=\"$user_hash\"");
    $row = 1;
    $basket_list = '';
    $total_sum = 0;
    if (gettype($result_basket) == 'array') {
        foreach ($result_basket as $row_data) {
            $id_basket = $row_data['id_basket'];
            $pr_number = $row_data['pr_number'];
            $pr_name = $row_data['pr_name'];
            $gender = $row_data['gender'];
            $size = $row_data['size'];
            $color = $row_data['color'];
            $photo = $row_data['photo'];
            $price_unit = $row_data['price_unit'];
            $quantity = $row_data['quantity'];
            $price_total = $price_unit * $quantity;
            $total_sum = $total_sum + $price_total;

        $result_image = sql_request("SELECT iconpath FROM images WHERE photoname=\"$photo\"");
        $path_to_icon = $result_image[0]['iconpath'];
        $result_cat_id = sql_request("SELECT id FROM catalogue WHERE pr_number=\"$pr_number\"");
        (gettype($result_cat_id) == 'array') ? $id = $result_cat_id[0]['id'] : $id = '';
        
        $row = $row + 1;
        $basket_list = $basket_list . <<<_END
        <div style="grid-area: $row/1" class="items"><a href="index.php?show=$id">$pr_number</a></div>
        <div style="grid-area: $row/2" class="items"><a href="index.php?show=$id">$pr_name</a></div>
        <div style="grid-area: $row/3" class="items"><a href="index.php?show=$id">$gender</a></div>
        <div style="grid-area: $row/4" class="items"><a href="index.php?show=$id">$size</a></div>
        <div style="grid-area: $row/5" class="items"><a href="index.php?show=$id">$color</a></div>
        <div style="grid-area: $row/6" class="items"><a href="index.php?show=$id"><img src="../$path_to_icon$photo" alt="иконка футболки"></a></div>
        <div style="grid-area: $row/7" class="items"><a href="index.php?show=$id">$price_unit</a></div>
        <div style="grid-area: $row/8" class="items"><a href="index.php?show=$id">$quantity</a></div>
        <div style="grid-area: $row/9" class="items"><a href="index.php?show=$id">$price_total</a></div>
        <div style="grid-area: $row/10" class="items col_button"><a href="index.php?item_del=$id_basket">удалить</a></div>
_END;
    }
    }
    $basket_view =[];
    $basket_view[0] = $basket_list;
    $basket_view[1] = $total_sum;
    return $basket_view;
}

function orders_show($user_name) {
    $result_basket = sql_request("SELECT `order_number` , `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `price_unit`, `quantity` FROM `basket` WHERE id_basket>0 AND id_customer=\"$user_name\"");
    $row = 1;
    $basket_list = '';
    $total_sum = 0;
    if (gettype($result_basket) == 'array') {
        foreach ($result_basket as $row_data) {
            $order_number = $row_data['order_number'];
            $pr_number = $row_data['pr_number'];
            $pr_name = $row_data['pr_name'];
            $gender = $row_data['gender'];
            $size = $row_data['size'];
            $color = $row_data['color'];
            $photo = $row_data['photo'];
            $price_unit = $row_data['price_unit'];
            $quantity = $row_data['quantity'];
            $price_total = $price_unit * $quantity;
            $total_sum = $total_sum + $price_total;

        $result_image = sql_request("SELECT iconpath FROM images WHERE photoname=\"$photo\"");
        $path_to_icon = $result_image[0]['iconpath'];
        $result_cat_id = sql_request("SELECT id FROM catalogue WHERE pr_number=\"$pr_number\"");
        (gettype($result_cat_id) == 'array') ? $id = $result_cat_id[0]['id'] : $id = '';
        
        $row = $row + 1;
        $basket_list = $basket_list . <<<_END
        <div style="grid-area: $row/1" class="items"><a href="index.php?show=$id">$pr_number</a></div>
        <div style="grid-area: $row/2" class="items"><a href="index.php?show=$id">$pr_name</a></div>
        <div style="grid-area: $row/3" class="items"><a href="index.php?show=$id">$gender</a></div>
        <div style="grid-area: $row/4" class="items"><a href="index.php?show=$id">$size</a></div>
        <div style="grid-area: $row/5" class="items"><a href="index.php?show=$id">$color</a></div>
        <div style="grid-area: $row/6" class="items"><a href="index.php?show=$id"><img src="../$path_to_icon$photo" alt="иконка футболки"></a></div>
        <div style="grid-area: $row/7" class="items"><a href="index.php?show=$id">$price_unit</a></div>
        <div style="grid-area: $row/8" class="items"><a href="index.php?show=$id">$quantity</a></div>
        <div style="grid-area: $row/9" class="items"><a href="index.php?show=$id">$price_total</a></div>
        <div style="grid-area: $row/10" class="items"><a href="index.php?show=$id">$order_number</a></div>
_END;
    }
    }
    $basket_view =[];
    $basket_view[0] = $basket_list;
    $basket_view[1] = $total_sum;
    return $basket_view;
}

function admin_orders_show() {
    $result_basket = sql_request("SELECT `id_basket`,`id_customer`,`order_number` , `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `price_unit`, `quantity` FROM `basket` WHERE id_basket>0");
    $row = 1;
    $basket_list = '';
    $total_sum = 0;
    if (gettype($result_basket) == 'array') {
        foreach ($result_basket as $row_data) {
            $id_basket = $row_data['id_basket'];
            $id_customer = $row_data['id_customer'];
            $order_number = $row_data['order_number'];
            $pr_number = $row_data['pr_number'];
            $pr_name = $row_data['pr_name'];
            $gender = $row_data['gender'];
            $size = $row_data['size'];
            $color = $row_data['color'];
            $photo = $row_data['photo'];
            $price_unit = $row_data['price_unit'];
            $quantity = $row_data['quantity'];
            $price_total = $price_unit * $quantity;
            $total_sum = $total_sum + $price_total;

        $result_image = sql_request("SELECT iconpath FROM images WHERE photoname=\"$photo\"");
        $path_to_icon = $result_image[0]['iconpath'];
        $result_cat_id = sql_request("SELECT id FROM catalogue WHERE pr_number=\"$pr_number\"");
        (gettype($result_cat_id) == 'array') ? $id = $result_cat_id[0]['id'] : $id = '';
        
        $row = $row + 1;
        $basket_list = $basket_list . <<<_END
        <div style="grid-area: $row/1" class="items"><a href="index.php?show=$id">$pr_number</a></div>
        <div style="grid-area: $row/2" class="items"><a href="index.php?show=$id">$pr_name</a></div>
        <div style="grid-area: $row/3" class="items"><a href="index.php?show=$id">$gender</a></div>
        <div style="grid-area: $row/4" class="items"><a href="index.php?show=$id">$size</a></div>
        <div style="grid-area: $row/5" class="items"><a href="index.php?show=$id">$color</a></div>
        <div style="grid-area: $row/6" class="items"><a href="index.php?show=$id"><img src="../$path_to_icon$photo" alt="иконка футболки"></a></div>
        <div style="grid-area: $row/7" class="items"><a href="index.php?show=$id">$price_unit</a></div>
        <div style="grid-area: $row/8" class="items"><a href="index.php?show=$id">$quantity</a></div>
        <div style="grid-area: $row/9" class="items"><a href="index.php?show=$id">$price_total</a></div>
        <div style="grid-area: $row/10" class="items"><a href="index.php?show=$id">$order_number</a></div>
        <div style="grid-area: $row/11" class="items"><a href="index.php?show=$id">$id_customer</a></div>
        <div style="grid-area: $row/12" class="items col_button"><a href="index.php?item_del=$id_basket&customer_del=$id_customer&order_id=$order_number">удалить</a></div>
_END;
    }
    }
    $basket_view =[];
    $basket_view[0] = $basket_list;
    $basket_view[1] = $total_sum;
    return $basket_view;
}

//выбор товара в корзину
//$basket_type = temp_basket для размещения во временной корзине
//$basket_type = basket для размещения во временной корзине
function put_in_basket($basket_type, $customer, $order_number, $user_hash, $product_selected) {
    $product_data = sql_request("SELECT `pr_number`,`pr_name`,`gender`,`size`,`color`,`photo`,`price`,`description` FROM `catalogue` WHERE id=$product_selected");
    $pr_number = $product_data[0]['pr_number'];
    $pr_name = $product_data[0]['pr_name'];
    $gender = $product_data[0]['gender'];
    $size = $product_data[0]['size'];
    $color = $product_data[0]['color'];
    $photo = $product_data[0]['photo'];
    $price_unit = $product_data[0]['price'];
    $description_index = $product_data[0]['description'];
    //проверяем, есть ли выбранный продукт уже в корзине
    if ($basket_type == 'basket') {
        $product_in_basket = sql_request("SELECT `pr_number`,`quantity` FROM `basket` WHERE pr_number=\"$pr_number\" AND id_customer=\"$customer\"");
        if (gettype($product_in_basket) <> 'array') {
            $quantity = 1;
            //добавляем новый товар в корзину
            sql_request("INSERT INTO `basket` (`id_basket`, `id_customer`, `order_number`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`,`description`,`price_unit`, `quantity`) VALUES (NULL,'$customer','$order_number','$pr_number','$pr_name','$gender','$size','$color','$photo', '$description_index','$price_unit','$quantity')");
        } else {
            $quantity = $product_in_basket[0]['quantity'] + 1;
            //обновляем количество ранее выбранного продукта
            sql_request("UPDATE `basket` SET `quantity`=$quantity WHERE pr_number=\"$pr_number\" AND id_customer=\"$customer\"");
        }
    } else {
        $product_in_basket = sql_request("SELECT `pr_number`,`quantity` FROM `temp_basket` WHERE pr_number=\"$pr_number\" AND temp_hash=\"$user_hash\"");
        if (gettype($product_in_basket) <> 'array') {
            $quantity = 1;
            //добавляем новый товар в корзину
            sql_request("INSERT INTO `temp_basket` (`id_basket`, `temp_hash`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`,`description`,`price_unit`, `quantity`) VALUES (NULL,'$user_hash','$pr_number','$pr_name','$gender','$size','$color','$photo', '$description_index','$price_unit','$quantity')");
        } else {
            $quantity = $product_in_basket[0]['quantity'] + 1;
            //обновляем количество ранее выбранного продукта
            sql_request("UPDATE `temp_basket` SET `quantity`=$quantity WHERE pr_number=\"$pr_number\" AND temp_hash=\"$user_hash\"");
        }
    }
}

//запросы SELECT возвращают индексированный массив ассоциированных массивов строк false, если ошибка
//запросы DELETE вернут true, если все как задумано или false, если ошибка
function sql_request($sql_request) {
    $db_array = [];
    require "../config/credentials.php";
    $connection = new mysqli($hostname, $username, $passname, $dbname);//подключение к базе данных
    if ($connection->connect_error) {
        echo "<p>Не удалось выполнить подключение к БД.</p>";
        return false;
    } else {
        $result = $connection->query($sql_request);//запрос к базе на выполнение
        if (!$result) {
            echo "<p>Не удалось выполнить запрос к БД.</p>";
            $connection->close();
            return false;
        } elseif ($result === true) {
            $connection->close();
            return true;
            } else {
                $rows_number = $result->num_rows;//количество строк, полученных в результате запроса
                if ($rows_number > 0) {//проверка на случай, если массив пустой
                    for ($i = 1; $i <= $rows_number; $i++) {
                        $singlerow = $result->fetch_array(MYSQLI_ASSOC);//выборка из строки в ассоциативный массив
                        $singlerow_rewrighted = [];//перезаписываем с учетом безопасности
                        foreach ($singlerow as $key => $value) $singlerow_rewrighted[htmlspecialchars($key)] = htmlspecialchars($value);$db_array[] = $singlerow_rewrighted;//размещение асс.массивов в индексный массив
                    }
                    $connection->close();
                    return $db_array;
                } else {
                    $connection->close();
                    return 'empty_table';
                }
            }
        }
    }