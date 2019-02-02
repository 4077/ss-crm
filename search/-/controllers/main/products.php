<?php namespace ss\crm\search\controllers\main;

class Products extends \Controller
{
    public function view()
    {
        /**
         * @var $svc \ss\crm\search\controllers\Svc
         */
        $svc = $this->c('svc');

        $products = $this->data('products');
        $offset = $this->data('offset');

        $output = [];

        foreach ($products as $product) {
            $v = $this->v('@product|');

            $svc->count++;

            $productXPack = xpack_model($product);

            $itemKey = ss()->products->getCartKey($product);

            $itemsKeys[] = $itemKey;

//            $inCartCount = $minicart->getQuantity($itemKey);

            $price = $product->price; // todo del
            $altPrice = $product->alt_price; // todo ?

            list($price, $stock, $reserved) = ss()->products->explodeMultisourceCache($product, 0, 0, true);

            $v->assign([
                           'TREE_NAME' => $svc->getTreeName($product),
                           'OFFSET'    => $offset,
                           'XPACK'     => $productXPack,
                           'ITEM_KEY'  => $itemKey,
                           //                           'SELECTED_CLASS'             => $selectedProductId == $product->id ? 'selected' : '',
                           'NAME'      => $product->remote_name,
                           'IN_ORDERS' => '—',
                           'RESERVED'  => $reserved,
                           'AVAILABLE' => trim_zeros(number_format__($stock - $reserved)),
                           'STOCK'     => $stock,
                           'PRICE'     => $price,
                           //                           'IN_CART_COUNT'              => $inCartCount,
                           //                           'IN_CART_COUNT_HIDDEN_CLASS' => $inCartCount ? '' : 'hidden'
                       ]);

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

            $image = $this->c('\std\images~:first', [
                'model'        => $product,
                'query'        => '100 100 fit',
                'href/enabled' => true,
                'cache_field'  => 'images_cache'
            ]);

            if ($image) {
                $v->assign([
                               'IMAGE' => $image->view
                           ]);
            }

            $output[] = $v->render();
        }

        return $output;
    }
}
