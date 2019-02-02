<?php namespace ss\crm\ui\controllers\bars\some;

class Tree extends \Controller
{
//    private $cat;

    private $s;

//    private $sCat;

    public function __create()
    {
//        if ($this->cat = $this->unpackModel('cat')) {
//            $this->instance_($this->cat->tree_id);

        $this->s = &$this->s('~');
//            $this->sCat = &$this->s('~|cat-' . $this->cat->id);
//        } else {
//            $this->lock();
//        }
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $v->assign([
                       'TREES_TREE' => $this->treesTreeView()
                   ]);

        $this->css();

        return $v;
    }

    private function treesTreeView()
    {
        $this->css('>node');

        $rootNode = ss()->trees->getRootNode();

        $s = $this->s('~');

        $selectedNodesIds = [];

        if ($s['location'] == 'cat') {
            if ($cat = unpack_model(ap($s, 'locations/cat/data/cat'))) {
                $selectedNodesIds = [$cat->tree_id];
            }
        }

        if ($s['location'] == 'search') {
            $selectedNodesIds = ap($s, 'locations/search/data/trees_ids');
        }

        return $this->c('\std\ui\tree~:view|' . $this->_nodeId() . '/' . $s['location'], [
            'default'           => [

            ],
            'node_control'      => [
                '>node:view|',
                [
                    'root_node_id'       => $rootNode->id,
                    'node'               => '%model',
                    'selected_nodes_ids' => $selectedNodesIds
                ]
            ],
            'query_builder'     => '>app:getQueryBuilder',
            'root_node_id'      => $rootNode->id,
            'expand'            => false,
            'sortable'          => false,
            'movable'           => false,
            'selected_node_id'  => $this->cat->tree_id ?? false,
            'root_node_visible' => false,
            'filter_ids'        => false
        ]);
    }
}
