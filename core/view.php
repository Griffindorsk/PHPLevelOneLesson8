<?php
require_once "../templates/layout.php";
?>
<div><?=$admin_notice?></div>
<div class="centerline">
    <div class="shop">
    <?=$admin_controls?>
        <div class="message">
            <p><?=$control_message;?></p>
        </div>
        <div class="products">
            <div class="catalogue">
                <div class="list">
                    <div class="headers col1h">
                        <p>Артикул</p>
                    </div>
                    <div class="headers col2h">
                        <p>Название</p>
                    </div>
                    <div class="headers col3h">
                        <p>Пол</p>
                    </div>
                    <div class="headers col4h">
                        <p>Размер</p>
                    </div>
                    <div class="headers col5h">
                        <p>Цвет</p>
                    </div>
                    <div class="headers col6h"></div>
                    <div class="headers col7h">
                        <p>Цена</p>
                    </div>
                    <div class="headers col8h">
                        <p>в корзину</p>
                    </div>
                    <?=$full_list?>
                </div>
            </div>
            <div class="description">
                <div class="text_description">
                    <h3>Описание товара</h3>
                    <h4>(кликните на любой параметр товара, чтобы увидеть)</h4>
                    <!-- <p>Хенли – простая модель с длинными рукавами, без воротника, но с глубоким вырезом на
                        пуговицах, из тонкого хлопка.</p> -->
                        <p><?=$text_description?></p>
                </div>
                <!-- <img class="product_photo" src="../products/images/05_t_shirt_violet.jpg" alt="описание"> -->
                <?=$product_photo?>
            </div>
            <div class="entry">
                <p><?=$user_logged_as?></p>
                <form action="#" method="POST" style="display: <?=$display_form?>">
                    <input name="new_customer_name" type="text" placeholder="ваше имя">
                    <input name="new_customer_password" type="password" placeholder="задайте ваш пароль">
                    <input name="new_customer_ok" type="submit" value="Войти">
                </form>
                <h4><a href="?user_logout" style="display: <?=$display_exit?>">Выйти</a></h4>
            </div>
        </div>
        <div class="control">
            <p class="button"><a href="index.php?clean_basket=full">Очистить корзину</a></p>
            <p class="button"><a href="index.php?order_basket=make">Оформить заказ</a></p>
            <p class="button"><a href="index.php?your_orders=show" target="_blank">Посмотреть заказы</a></p>
        </div>
        <div class="products">
            <div class="basket">
                <div class="list">
                    <div class="headers col1h">
                        <p>Артикул</p>
                    </div>
                    <div class="headers col2h">
                        <p>Название</p>
                    </div>
                    <div class="headers col3h">
                        <p>Пол</p>
                    </div>
                    <div class="headers col4h">
                        <p>Размер</p>
                    </div>
                    <div class="headers col5h">
                        <p>Цвет</p>
                    </div>
                    <div class="headers col6h"></div>
                    <div class="headers col7h">
                        <p>Цена за ед.</p>
                    </div>
                    <div class="headers col8h">
                        <p>Кол-во</p>
                    </div>
                    <div class="headers col9h">
                        <p>Цена</p>
                    </div>
                    <div class="headers col10h">
                        <p></p>
                    </div>
                    <?=$basket_list?>
                </div>
                <!-- <div class="list">список товаров</div> -->
                <div class="total_sum"><p>Общая стоимость товаров в корзине: <strong><?=$total_sum?></strong></p></div>
            </div>
        </div>
    </div>
</div>