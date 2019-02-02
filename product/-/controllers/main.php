<?php namespace ss\crm\product\controllers;

class Main extends \Controller
{
    private $product;

    public function __create()
    {
        if ($this->product = $this->unpackModel('product')) {
            $this->instance_($this->product->id);
        } else {
            $this->lock();
        }
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $guestMode = $this->data('guest_mode');

        $product = $this->product;

        $ssProducts = ss()->products;

        $itemKey = $ssProducts->getCartKey($product);

//        $inCartCount = cart('tdui-crm')->getQuantity($itemKey);

        $cat = $product->cat;

        if ($dev = true) {
            $this->c('quantifyKnob:view', ['product' => $product]);
        }

        $price = $product->price;
        $altPrice = $product->alt_price;

        $v->assign([
                       'CAT_BUTTON'                 => $this->c('\std\ui button:view', [
                           'visible' => !$guestMode && $this->s('\ss\crm\ui~:location') != 'cat',
                           'path'    => '>xhr:openCat',
                           'data'    => [
                               'product' => xpack_model($product)
                           ],
                           'class'   => 'open_cat_button',
                           'content' => 'Перейти в категорию товара'
                       ]),
                       'CAT_NAME'                   => $cat->name,
                       'CAT_ROUTE'                  => '/c/' . $cat->articul,
                       'NAME'                       => $ssProducts->getName($product),
                       'ARTICUL'                    => $product->articul,
                       'PRICE'                      => $price > 0 ? number_format__($price) : '—',
                       'STOCK'                      => $product->stock,
                       'RESERVED'                   => $product->reserved,
                       'IN_ORDERS'                  => '0.00',
                       'AVAILABLE_NOW'              => $product->stock - $product->reserved - '0.00',
                       'DIVISIONS_DATA'             => $this->c('>divisionsData:view', [
                           'product' => $product
                       ]),
                       //                       'ADD_TO_CART_BUTTON'         => $this->c('\std\ui button:view', [
                       //                           'visible' => !$guestMode,
                       //                           'path'    => '>xhr:addToCart',
                       //                           'data'    => [
                       //                               'product' => xpack_model($product)
                       //                           ],
                       //                           'class'   => 'add_to_cart_button',
                       //                           'content' => 'В корзину'
                       //                       ]),
                       //                       'IN_CART_COUNT'              => $inCartCount,
                       //                       'IN_CART_COUNT_HIDDEN_CLASS' => $inCartCount ? '' : 'hidden',
                       'SEARCH_IN_SUPPLIERS_BUTTON' => $this->c('\std\ui button:view', [
                           'visible' => !$guestMode,
                           'path'    => '>xhr:searchInSuppliers',
                           'data'    => [
                               'product' => xpack_model($product)
                           ],
                           'class'   => 'search_in_suppliers_button',
                           'content' => 'Искать у поставщиков'
                       ])
                   ]);

//        if ($inCartCount) {
//            $v->assign('in_cart_count', [
//                'VALUE' => $inCartCount
//            ]);
//        }

        if ($units = $product->units) {
            $v->assign('units', [
                'VALUE' => $units
            ]);
        }

        $altUnits = $product->alt_units;

        if ($altPrice > 0 || $altUnits) {
            $v->assign('alt_price', [
                'VALUE' => $altPrice > 0 ? number_format__($altPrice) : '—'
            ]);

            if ($altUnits) {
                $v->assign('alt_price/alt_units', [
                    'VALUE' => $altUnits
                ]);
            }
        }

        $v = $this->assignProps($v);
        $v = $this->assignImage($v);

        $this->c('\plugins\fancybox3~:bind', [
            'selector'      => $this->_selector('|'),
            'item_selector' => 'a'
        ]);

        $this->css(':\css\std~, \css\std flex');

        $this->widget(':|', [
            'itemKey' => $itemKey
        ]);

        return $v;
    }

    private function assignProps(\ewma\Views\View $v)
    {
        if ($props = _j($this->product->props)) {
            $v->assign('props', [
                'CONTENT' => $this->c('>props:view', [
                    'props' => _j($this->product->props)
                ])
            ]);
        }

        return $v;
    }

    private function assignImage(\ewma\Views\View $v)
    {
        $image = $this->c('\std\images~:first', [
            'model'       => $this->product,
            'query'       => '300 250 fit',
            'href'        => [
                'enabled' => true,
                'query'   => ''
            ],
            'cache_field' => 'images_cache'
        ]);

        if ($image) {
            $v->assign('IMAGE', $image->view);
        }

        if (ss()->products->isEditable($this->product)) {
            $v->assign('IMAGES_EDITOR_BUTTON', $this->c('\std\ui button:view', [
                'path'    => '>xhr:imagesDialog',
                'data'    => [
                    'product' => xpack_model($this->product)
                ],
                'class'   => 'button blue small',
                'content' => 'Загрузить картинку'
            ]));
        }

        return $v;
    }
}
