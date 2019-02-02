<?php namespace ss\crm;

class Ui
{
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new self;
        }

        return static::$instance;
    }

//    private $

    public function __construct()
    {

    }

    public function loadCat($cat)
    {
//        appc()->jquery("\ss\crm\ui~:. [port='A']")->html(appc('\ss\crm\cat~:view', [
//            'cat' => $cat
//        ]));

        appc()->jsRaw("window.history.replaceState(null, null, '/cat/" . $cat->id . "/')");

//        if ($selectedProductId = appc()->s('\ss\crm\ui~:selected_product_id|cat-' . $cat->id)) {
//            if ($product = \ss\models\Product::find($selectedProductId)) {
//                appc()->jquery("\ss\crm\ui~:. [port='B']")->html(appc('\ss\crm\product~:view', [
//                    'product' => $product
//                ]));
//            }
//        }
//
//        appc()->widget('\ss\crm\nav~:|' . $cat->tree_id, 'setSelection', $cat->id);
//
//        $this->reloadMainBar();
//        $this->reloadInfoBar();
    }

    public function loadProduct($product, $setHistoryState = false)
    {
        appc()->jquery("\ss\crm\ui~:. [port='B']")->html(appc('\ss\crm\product~:view', [
            'product' => $product
        ]));

        if ($setHistoryState) {
            appc()->jsRaw("window.history.replaceState(null, null, '/product/" . $product->id . "/')");
        }

        appc()->widget('\ss\crm\ui~:', 'showPort', 'B');
    }

    public function reloadMainBar()
    {
        appc('\ss\crm\ui bars/main:reload', [
//            'cat' => $cat
        ]);
    }

    public function reloadInfoBar()
    {
        appc('\ss\crm\ui bars/info:reload', [
//            'cat' => $cat
        ]);
    }
}
