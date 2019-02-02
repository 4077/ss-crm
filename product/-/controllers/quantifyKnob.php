<?php namespace ss\crm\product\controllers;

class QuantifyKnob extends \Controller
{
    public function reload()
    {
        $this->jquery()->replace($this->view());
    }

    public function view()
    {
        $v = $this->v();

        $s = $this->s(false, [
            'value'     => 1,
            'magnitude' => 50
        ]);

        $product = $this->unpackModel('product');
        $productXPack = xpack_model($product);

        $quantity = cart('tdui-crm')->stage->getQuantity(ss()->products->getCartKey($product));

        if ($quantity > $s['magnitude']) {
            $quantity = $s['magnitude'];

            cart('tdui-crm')->stage->setQuantity(ss()->products->getCartKey($product), $quantity);
        }

        $v->assign([
                       'MAGNITUDE'  => $s['magnitude'],
                       'KNOB'       => $this->c('\plugins\knob~:view', [
                           'min'            => 1,
                           'max'            => $s['magnitude'],
                           'value'          => $quantity,
                           'update_request' => $this->_abs('>xhr:updateValue', [
                               'product' => $productXPack
                           ])
                       ]),
                       'ADD_BUTTON' => $this->c('\std\ui button:view', [
                           'path'    => '>xhr:addToCart',
                           'data'    => [
                               'product' => $productXPack
                           ],
                           'class'   => 'add_button',
                           'content' => 'Добавить'
                       ])
                   ]);

        foreach ($this->magnitudes as $magnitude) {
            $v->assign('magnitude', [
                'BUTTON' => $this->c('\std\ui button:view', [
                    'path'    => '>xhr:updateMagnitude',
                    'data'    => [
                        'magnitude' => $magnitude,
                        'product'   => $productXPack
                    ],
                    'class'   => 'magnitude ' . ($magnitude == $s['magnitude'] ? 'selected' : ''),
                    'content' => $magnitude
                ])
            ]);
        }

        $this->css();

        $this->widget(':');

        return $v;
    }

    private $magnitudes = [50, 100, 150, 300, 500, 1000];
}
