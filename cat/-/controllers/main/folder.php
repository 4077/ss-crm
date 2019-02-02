<?php namespace ss\crm\cat\controllers\main;

class Folder extends \Controller
{
    public function view()
    {
        $v = $this->v('|');

        $v->assign([
                       'PRODUCTS' => implode($this->c('@products:view', [
                           'take' => 15
                       ], 'tree, cat, division_id, warehouse_id, guest_mode'))
                   ]);

        $this->css();

        return $v;
    }
}
