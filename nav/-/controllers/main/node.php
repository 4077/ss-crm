<?php namespace ss\crm\nav\controllers\main;

class Node extends \Controller
{
    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $cat = $this->data['cat'];

        $v = $this->v('|' . $cat->id);

        $v->assign([
                       'CONTENT' => ss()->cats->getShortName($cat)
                   ]);

        $this->css();

        return $v;
    }
}
