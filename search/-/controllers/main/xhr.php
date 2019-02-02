<?php namespace ss\crm\search\controllers\main;

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
        }
    }

    public function openProduct()
    {
        if ($product = $this->unxpackModel('product')) {
            \ss\crm\ui()->loadProduct($product);

            $cat = $product->cat;

//            $sessionCatId = $cat->type == 'container' ? $cat->parent_id : $cat->id;
//            $this->s('\ss\crm\ui~:selected_product_id|cat-' . $sessionCatId, $product->id, RR);

            $this->s('\ss\crm\ui~:locations/search/data/selected_product_id', $product->id, RR);
        }
    }

    public function loadProducts()
    {
        $offset = $this->data('offset');

        $s = $this->s('\ss\crm\ui~');

        $query = ap($s, 'locations/search/data/query');
        $treesIds = ap($s, 'locations/search/data/trees_ids');

        $products = ss()->search->new()
            ->offset($offset)
            ->take(5)
            ->trees($treesIds)
            ->search($query);

        $this->c('~')->log('CRM SEARCH ' . $query . ' LOADED ' . count($products));

        $productsViews = $this->c('@products:view', [
            'products' => $products,
            'offset'   => $offset,
        ]);

        $this->widget('~:|', 'appendProducts', [
            'count'         => count($productsViews),
            'productsViews' => implode($productsViews)
        ]);
    }
}
