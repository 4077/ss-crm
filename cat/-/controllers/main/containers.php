<?php namespace ss\crm\cat\controllers\main;

class Containers extends \Controller
{
    public function view()
    {
        $svc = $this->c('svc');

        $orderingField = $this->s('\ss\crm\ui~:ordering'); // todo optimize

        $cat = $this->data['cat'];
        $divisionId = $this->data['division_id'];
        $warehouseId = $this->data('warehouse_id');

        $containers = $cat->containers()->orderBy($orderingField)->get();

        $output = [];

        foreach ($containers as $container) {
            $v = $this->v('@container');

            $productsViews = $this->c('@products:view', [
                'cat'  => $container,
                'take' => 15
            ], 'tree, division_id, warehouse_id');

            $productsCount = count($productsViews);


            $v->assign([
                           'NAME'     => $container->name ?: $container->short_name,
                           'PRODUCTS' => implode($productsViews)
                       ]);

            $pages = $container->containedPages()->orderBy($orderingField)->get();

            foreach ($pages as $page) {
                $v->assign('page', [
                    'XPACK' => xpack_model($page),
                    'NAME'  => $page->name ?: $page->short_name,
                ]);
            }

            $output[] = $v->render();
        }

        return $output;
    }
}
