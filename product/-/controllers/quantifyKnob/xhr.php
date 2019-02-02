<?php namespace ss\crm\product\controllers\quantifyKnob;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function updateMagnitude()
    {
        if ($product = $this->unxpackModel('product')) {
            $magnitude = $this->data('magnitude');

            $this->s('<:magnitude|', $magnitude, RR);

            $quantity = cart('tdui-crm')->stage->getQuantity(ss()->products->getCartKey($product));

            if ($quantity > $magnitude) {
                cart('tdui-crm')->stage->setQuantity(ss()->products->getCartKey($product), $magnitude);
            }

            $this->c('<:reload', [
                'product' => $product
            ]);
        }
    }

    public function updateValue()
    {
        if ($product = $this->unxpackModel('product')) {
            $value = $this->data('value');

            if ($value < 1) {
                $value = 1;
            }

            cart('tdui-crm')->stage->setQuantity(ss()->products->getCartKey($product), $value);
        }
    }

    public function addToCart()
    {
        if ($product = $this->unxpackModel('product')) {
            $priceField = 'price';

            cart('tdui-crm')->add(ss()->products->getCartKey($product), [
                'name'  => $product->remote_name,
                'price' => $product->{$priceField},
                'model' => pack_model($product)
            ]);
        }

        $this->c('\std\ui\layer~:close|quantifyKnob');
    }
}
