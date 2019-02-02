<?php namespace ss\crm\cat\controllers;

class Main extends \Controller
{
    private $tree;

    private $cat;

    private $s;

    private $sCat;

    public function __create()
    {
        if ($this->cat = $this->unpackModel('cat')) {
            $this->instance_($this->cat->id);

            $this->tree = $this->cat->tree;

            $this->s = &$this->s('\ss\crm\ui~');
            $this->sCat = &$this->s('\ss\crm\ui~|cat-' . $this->cat->id);
        } else {
            $this->lock();
        }
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $svc = $this->c('@svc');

        $v = $this->v('|');

        $cat = $this->cat;
        $tree = $this->tree;

        $this->assignNested($v);

        $divisionId = ap($this->s, 'filters/multisource/division_id');
        $warehouseId = ap($this->s, 'filters/multisource/warehouses_ids_by_divisions_ids/' . $divisionId);

        $guestMode = $this->data('guest_mode');

        $productsData = [
            'tree'         => $tree,
            'cat'          => $cat,
            'division_id'  => $divisionId,
            'warehouse_id' => $warehouseId,
            'guest_mode'   => $guestMode
        ];

        if ($tree->mode == 'folders') {
            $v->assign('CAT', $this->c('>folder:view', $productsData));
        }

        if ($tree->mode == 'pages') {
            $v->assign('CAT', $this->c('>page:view', $productsData));
        }

        $this->css(':\css\std~, \css\std flex');

        $this->widget(':|', [
            '.r'            => [
                'openProduct'  => $this->_p('>xhr:openProduct'),
                'openCat'      => $this->_p('>xhr:openCat'),
                'addToCart'    => $this->_p('>xhr:addToCart'),
                'loadProducts' => $this->_p('>xhr:loadProducts|')
            ],
            'productsData'  => pack_models($productsData),
            'minTailHeight' => 2000,
            'offset'        => $svc->count,
            'guestMode'     => $guestMode
        ]);

        return $v;
    }

    private function assignNested(\ewma\Views\View $v)
    {
        $cat = $this->cat;
        $tree = $this->tree;

        $treeMode = $tree->mode;

        $orderingField = ap($this->s, 'ordering') ?? 'name'; // костыль для гостевого

        $cats = [];

        if ($treeMode == 'folders') {
            $cats = $cat->folders()->orderBy($orderingField)->get();
        }

        if ($treeMode == 'pages') {
            $cats = $cat->pages()->where('container_id', false)->orderBy($orderingField)->get();
        }

        foreach ($cats as $cat) {
            $v->assign('cat', [
                'TYPE'       => $treeMode,
                'ICON_CLASS' => $treeMode == 'folders' ? 'fa-folder' : 'fa-file',
                'NAME'       => $cat->short_name ?: $cat->name,
                'XPACK'      => xpack_model($cat)
            ]);
        }
    }
}
