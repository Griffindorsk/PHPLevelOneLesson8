<?php
require_once "../templates/layout.php";
?>
<div class="centerline">
    <div class="shop">
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
                        <p>Номер заказа</p>
                    </div>
                    <?=$orders_list?>
                </div>
                <div class="total_sum"><p>Стоимость всех заказов: <strong><?=$orders_sum?></strong></p></div>
            </div>
        </div>
    </div>
</div>