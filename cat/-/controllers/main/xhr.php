<?php namespace ss\crm\cat\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function addToCart()
    {
        if ($product = $this->unxpackModel('product')) {
            $this->c('\std\ui\layer~:open|quantifyKnob', [
                'content_call' => $this->_abs('@product quantifyKnob:view', [
                    'product' => pack_model($product)
                ])
            ]);
        }
    }

    public function openCat()
    {
        if ($cat = $this->unxpackModel('cat')) {
            \ss\crm\ui()->loadCat($cat);

            $this->s('\ss\crm\ui~:locations/cat/data/cat', pack_models($cat), RR);

            $this->c('\ss\crm\ui~:reload');
        }
    }

    public function openProduct()
    {
        if ($product = $this->unxpackModel('product')) {
            \ss\crm\ui()->loadProduct($product, true);

            $cat = $product->cat;

            $sessionCatId = $cat->type == 'container' ? $cat->parent_id : $cat->id;

            $this->s('\ss\crm\ui~:selected_product_id|cat-' . $sessionCatId, $product->id, RR);
        }
    }

    public function loadProducts()
    {
        $productsData = unpack_models($this->data('products_data'));

        $offset = $this->data('offset');

        ra($productsData, [
            'offset' => $offset
        ]);

        $treeMode = $productsData['tree']->mode;

        if ($treeMode == 'folders') {
            $productsViews = $this->c('@products:view', $productsData);

            $this->widget('~:|', 'appendProducts', [
                'count'         => count($productsViews),
                'productsViews' => implode($productsViews)
            ]);
        }

        if ($treeMode == 'pages') {
            /*
             * todo \ss\crm\cat\controllers\main\Xhr::loadProducts pages mode
             */
        }
    }

    public function loadPageProducts()
    {
        $productsData = unpack_models($this->data('products_data'));
        $offset = $this->data('offset');

        ra($productsData, [
            'offset' => $offset
        ]);


    }
}
