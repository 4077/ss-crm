<?php namespace ss\crm\product\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function openCat()
    {
        if ($product = $this->unxpackModel('product')) {
            $s = &$this->s('\ss\crm\ui~:');

            ra($s, [
                'location'  => 'cat',
                'locations' => [
                    'cat' => [
                        'data' => [
                            'cat'                 => pack_model($product->cat),
                            'selected_product_id' => $product->id
                        ]
                    ]
                ]
            ]);

            appc()->jsRaw("window.history.replaceState(null, null, '/product/" . $product->id . "/')");

            $this->c('\ss\crm\ui~:reload');
        }
    }

    public function searchInSuppliers()
    {
        if ($product = $this->unxpackModel('product')) {
            $s = &$this->s('\ss\crm\ui~:');

            ra($s, [
                'location'  => 'search',
                'locations' => [
                    'search' => [
                        'data' => [
                            'query'     => $product->name,
                            'trees_ids' => [21, 22, 29, 30, 31]
                        ]
                    ]
                ]
            ]);

            $this->c('\ss\crm\ui~:reload');

            $this->c('\ss\crm -')->log('SEARCH IN SUPPLIERS ' . $product->name);
        }
    }

    public function addToCart()
    {
        if ($product = $this->unxpackModel('product')) {
            $this->c('\std\ui\layer~:open|quantifyKnob', [
                'content_call' => $this->_abs('quantifyKnob:view', [
                    'product' => pack_model($product)
                ])
            ]);
        }
    }

    public function imagesDialog()
    {
        if ($product = $this->unxpackModel('product')) {
            if (ss()->products->isEditable($product)) {
//                $this->c('\std\ui\dialogs~:open:productImages, ss|ss/cats', [
//                    'path'          => '\std\images\ui~:view|ss/cp/products/product',
//                    'data'          => [
//                        'imageable' => pack_model($product),
//                        'href'      => [
//                            'enabled' => true
//                        ],
//                        'callbacks' => [
//                            'update' => $this->_abs('\ss\cats\cp\product~app:imagesUpdate', [
//                                'product' => '%imageable'
//                            ])
//                        ]
//                    ],
//                    'class'         => 'padding',
//                    'pluginOptions' => [
//                        'title' => 'Картинки товара ' . ($product->name ? $product->name : '...')
//                    ],
//                    'default'       => [
//                        'pluginOptions' => [
//                            'width'  => 600,
//                            'height' => 200
//                        ]
//                    ]
//                ]);

                $this->c('\std\ui\layer~:open|ss/cats', [
                    'content_call' => $this->_abs('\std\images\ui~:view|ss/cp/products/product', [
                        'imageable' => pack_model($product),
                        'href'      => [
                            'enabled' => true
                        ],
                        'callbacks' => [
                            'update' => $this->_abs('\ss\cats\cp\product~app:imagesUpdate', [
                                'product' => '%imageable'
                            ])
                        ]
                    ])
                ]);
            }
        }
    }
}
