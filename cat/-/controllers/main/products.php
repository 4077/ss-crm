<?php namespace ss\crm\cat\controllers\main;

class Products extends \Controller
{
    public function view()
    {
        $svc = $this->c('svc');

        $orderingField = $this->s('\ss\crm\ui~:ordering') ?? 'name'; // todo optimize

        $cat = $this->data['cat'];
        $divisionId = $this->data('division_id');
        $warehouseId = $this->data('warehouse_id');

        $offset = $this->data('offset') ?? 0;

        if ($this->data('guest_mode')) {
            $products = $cat->products()->orderBy($orderingField)->get();
        } else {
            $take = $this->data('take') ?? 5;

            if ($take == 'all') {
                $products = $cat->products()->orderBy($orderingField)->get();
            } else {
                $products = $cat->products()->skip($offset)->take($take)->orderBy($orderingField)->get();
            }
        }

        $sessionCatId = $cat->type == 'container' ? $cat->parent_id : $cat->id;
        $selectedProductId = $this->s('\ss\crm\ui~:selected_product_id|cat-' . $sessionCatId);

//        $cart = cart('tdui-crm');

        $ssProducts = ss()->products;

        $itemsKeys = [];

        $output = [];

        foreach ($products as $product) {
            $v = $this->v('@product|');

            $svc->count++;

            $productXPack = xpack_model($product);

            $itemKey = ss()->products->getCartKey($product);

            $itemsKeys[] = $itemKey;

//            $inCartCount = $cart->getQuantity($itemKey);

            $price = $product->price; // todo del
            $altPrice = $product->alt_price; // todo ?

            // todo в цикле тяжело
            list($price, $stock, $reserved) = ss()->products->explodeMultisourceCache($product, $divisionId, $warehouseId, true);

            $v->assign([
                           'OFFSET'         => $offset,
                           'XPACK'          => $productXPack,
                           'ITEM_KEY'       => $itemKey,
                           'SELECTED_CLASS' => $selectedProductId == $product->id ? 'selected' : '',
                           'NAME'           => $ssProducts->getName($product),
                           'IN_ORDERS'      => '—',
                           'RESERVED'       => $reserved,
                           'AVAILABLE'      => trim_zeros(number_format__($stock - $reserved)),
                           'STOCK'          => $stock,
                           'PRICE'          => $price,
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
