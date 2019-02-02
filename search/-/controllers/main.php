<?php namespace ss\crm\search\controllers;

class Main extends \Controller
{
    private $s;

    public function __create()
    {
        $this->s = &$this->s('\ss\crm\ui~');
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $svc = $this->c('svc');

        $v = $this->v('|');

        $query = ap($this->s, 'locations/search/data/query');
        $treesIds = ap($this->s, 'locations/search/data/trees_ids');

        $products = ss()->search->new()
            ->take(20)
            ->trees($treesIds)
            ->search($query);

        $this->c('\ss\crm -')->log('SEARCH ' . $query . ' FOUND ' . count($products));

        $productsViews = $this->c('>products:view', [
            'products' => $products
        ]);

        $v->assign([
                       'PRODUCTS' => implode($productsViews)
                   ]);

        $this->css();

        $this->widget(':|', [
            '.r'            => [
                'openProduct'  => $this->_p('>xhr:openProduct'),
                'openCat'      => $this->_p('>xhr:openCat'),
                'addToCart'    => $this->_p('>xhr:addToCart'),
                'loadProducts' => $this->_p('>xhr:loadProducts|')
            ],
            //            'productsData'  => pack_models($productsData),
            'minTailHeight' => 2000,
            'offset'        => $svc->count
            //            'itemsKeys' => $itemsKeys
        ]);

        return $v;
    }
}
