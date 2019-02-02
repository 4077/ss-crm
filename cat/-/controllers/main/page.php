<?php namespace ss\crm\cat\controllers\main;

class Page extends \Controller
{
    public function view()
    {
        $svc = $this->c('@svc');

        $orderingField = $this->s('\ss\crm\ui~:ordering'); // todo optimize

        $cat = $this->data['cat'];

        $v = $this->v('|');

        $containers = $cat->containers()->orderBy($orderingField)->get();

        foreach ($containers as $container) {
            $productsViews = $this->c('@products:view', [
                'cat'  => $container,
                'take' => 'all'
            ], 'tree, division_id, warehouse_id, guest_mode');

            $v->assign('container', [
                'NAME'     => $container->name ?: $container->short_name,
                'PRODUCTS' => implode($productsViews)
            ]);

            $pages = $container->containedPages()->orderBy($orderingField)->get();

            foreach ($pages as $page) {
                $v->assign('container/page', [
                    'XPACK' => xpack_model($page),
                    'NAME'  => $page->name ?: $page->short_name,
                ]);
            }
        }

        $this->css();

        return $v;
    }
}
