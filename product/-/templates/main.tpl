<div class="{__NODE_ID__}" instance="{__INSTANCE__}">

    {*<div class="cat" route="{CAT_ROUTE}">*}
    {*<div class="icon">*}
    {*<div class="folder fa fa-folder"></div>*}
    {*<div class="arrow fa fa-arrow-left"></div>*}
    {*</div>*}
    {*<div class="content">*}
    {*<div class="name">{CAT_NAME}</div>*}
    {*</div>*}
    {*</div>*}

    <div class="cat">
        {CAT_BUTTON}
    </div>

    <div class="name">{NAME}</div>

    <div class="articul">
        <div class="label">Артикул:</div>
        <div class="value">{ARTICUL}</div>
    </div>

    <div class="product">
        <div class="image">{IMAGE}

            {IMAGES_EDITOR_BUTTON}</div>

        <div class="info">

            <div class="df fdc">
                <div class="divisions_data">
                    {DIVISIONS_DATA}
                </div>

                {*<div class="prices">
                    <div class="price">{PRICE} руб.<!-- units -->/{VALUE}<!-- / --></div>
                    <!-- alt_price -->
                    <div class="alt_price">{VALUE} руб.<!-- alt_price/alt_units -->/{VALUE}<!-- / --></div>
                    <!-- / -->
                </div>

                <div class="available_now">
                    <div class="label">Доступно сейчас:</div>
                    <div class="value">{AVAILABLE_NOW}<!-- units --> {VALUE}<!-- / --></div>
                </div>

                <!-- props -->
                <div class="props">
                    {CONTENT}
                </div>
                <!-- / -->*}
            </div>

        </div>

        {*<div class="fields">
            <div class="field stock">
                <div class="label">На складе</div>
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
        </div>*}
    </div>

    <div class="suppliers_search">
        {SEARCH_IN_SUPPLIERS_BUTTON}
    </div>

    {*<div class="add_to_cart_button_container">
        {ADD_TO_CART_BUTTON}
        <div class="in_cart_count {IN_CART_COUNT_HIDDEN_CLASS}">
            {IN_CART_COUNT}
        </div>
    </div>*}

</div>
