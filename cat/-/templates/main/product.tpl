<div class="product {SELECTED_CLASS}" offset="{OFFSET}" xpack="{XPACK}" item_key="{ITEM_KEY}">
    <div class="image">
        {IMAGE}
    </div>

    <div class="content">
        <div class="name">{NAME}</div>

        <div class="info">
            <div class="prices">
                <div class="price">{PRICE} руб.<!-- units -->/{VALUE}<!-- / --></div>
                <!-- alt_price -->
                <div class="alt_price">{VALUE} руб.<!-- alt_price/alt_units -->/{VALUE}<!-- / --></div>
                <!-- / -->
                <div class="available">
                    <div class="label">Доступно сейчас:</div>
                    <div class="value">{AVAILABLE}<!-- units --> {VALUE}<!-- / --></div>
                </div>

                {*<div class="add_to_cart_button_container">
                    <div class="add_to_cart_button">В корзину</div>
                    <div class="in_cart_count {IN_CART_COUNT_HIDDEN_CLASS}">
                        {IN_CART_COUNT}
                    </div>
                </div>*}
            </div>
            <div class="fields">
                <div class="field stock">
                    <div class="label">В наличии</div>
                    <div class="value">{STOCK}<!-- units --> {VALUE}<!-- / --></div>
                </div>
                <div class="field reserved">
                    <div class="label">В резерве</div>
                    <div class="value">{RESERVED}<!-- units --> {VALUE}<!-- / --></div>
                </div>
                <div class="field in_orders">
                    <div class="label">В заказах</div>
                    <div class="value">{IN_ORDERS}<!-- units --> {VALUE}<!-- / --></div>
                </div>
            </div>
        </div>
    </div>
</div>
