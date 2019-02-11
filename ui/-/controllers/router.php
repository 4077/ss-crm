<?php namespace ss\crm\ui\controllers;

class Router extends \Controller implements \ewma\Interfaces\RouterInterface
{
    public function getResponse()
    {
        $this->route('c/{articul}')->to(':catByArticul');
        $this->route('p/{articul}')->to(':productByArticul');

        if ($this->_user()) {
            if ($this->a('tdui:crm/view')) {
                $this->route()->to(':default', [
                    'default_tree_id' => $this->data('default_tree_id')
                ]);

                $this->route('cat/{id}')->to(':cat');
                $this->route('product/{id}')->to(':product');
                $this->route('search/{query}')->to(':search');
            } else {
                $this->route('*')->to('\std\layouts\accessDenied~:view');
            }
        } else {
            $this->route('*')->to('\std\ui\auth login:view');
        }

        $this->route('*')->to('\layouts\notFound~:view');

        return $this->routeResponse();
    }

    public function default()
    {
        return $this->c('~:view', [
            'location' => 'cat'
        ], 'default_tree_id');
    }

    public function search()
    {
        return $this->c('~:view', [
            'location' => 'search',
            'search'   => $this->data('query')
        ]);
    }

    public function catByArticul()
    {
        $articul = $this->data('articul');

        $cats = \ss\models\Cat::where('articul', $articul)->get();

        if ($cat = $cats[0] ?? false) {
            if ($this->a('tdui:crm/view')) {
                return $this->c('~:view', [
                    'location' => 'cat',
                    'cat'      => $cat
                ]);
            } else {
                return $this->c('\ss\crm\cat~:view', [
                    'cat'        => $cat,
                    'guest_mode' => true
                ]);
            }
        }
    }

    public function cat()
    {
        if ($cat = \ss\models\Cat::find($this->data('id'))) {
            return $this->c('~:view', [
                'location' => 'cat',
                'cat'      => $cat
            ]);
        }
    }

    public function productByArticul()
    {
        $articul = $this->data('articul');

        $products = \ss\models\Product::where('articul', $articul)->get();

        if ($product = $products[0] ?? false) {
            $cat = $product->cat;

            if ($cat->type == 'container') {
                $cat = $cat->parent;
            }

            if ($this->a('tdui:crm/view')) {
                $this->s('~:|cat-' . $cat->id, [
                    'selected_product_id' => $product->id
                ], RA);

                return $this->c('~:view', [
                    'location' => 'cat',
                    'cat'      => $cat
                ]);
            } else {
                return $this->c('\ss\crm\product~:view', [
                    'product'    => $product,
                    'guest_mode' => true
                ]);
            }
        }
    }

    public function product()
    {
        if ($product = \ss\models\Product::find($this->data('id'))) {
            $cat = $product->cat;

            if ($cat->type == 'container') {
                $cat = $cat->parent;
            }

            $this->s('~:|cat-' . $cat->id, [
                'selected_product_id' => $product->id
            ], RA);

            return $this->c('~:view', [
                'location' => 'cat',
                'cat'      => $cat
            ]);
        }
    }
}
