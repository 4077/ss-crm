<?php namespace ss\crm\nav\controllers;

class Main extends \Controller
{
    private $tree;

    private $cat;

    private $rootCat;

    public function __create()
    {
        $s = $this->s('\ss\crm\ui~:');

        if ($s['location'] == 'cat') {
            if ($this->cat = unpack_model(ap($s, 'locations/cat/data/cat'))) {
                $this->tree = $this->cat->tree;

                $this->instance_($this->tree->id);

                $this->rootCat = ss()->trees->getRootCat($this->tree->id);
            } else {
                $this->lock();
            }
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
        $v = $this->v('|');

        $tree = $this->tree;
        $cat = $this->cat;
        $rootCat = $this->rootCat;

        $v->assign([
                       'CONTENT' => $this->c('\std\ui\tree~:view|' . $this->_nodeInstance(), [
                           'query_builder'     => $this->_abs('>app:treeQueryBuilder', [
                               'tree' => pack_model($tree)
                           ]),
                           'node_control'      => [
                               '>node:view',
                               [
                                   'cat' => '%model'
                               ]
                           ],
                           'selected_node_id'  => $cat->id ?? false,
                           'root_node_visible' => false,
                           'root_node_id'      => $rootCat->id ?? false,
                           'expand'            => false,
                           'movable'           => false,
                           'sortable'          => false,
                           'callbacks'         => [
                               'subnodesToggle' => $this->_p('>app:treeReload')
                           ]
                       ])
                   ]);

        $this->css();

        $this->widget(':|', [
            '.r' => [
                'selectCat' => $this->_p('>xhr:selectCat')
            ]
        ]);

        return $v;
    }
}
