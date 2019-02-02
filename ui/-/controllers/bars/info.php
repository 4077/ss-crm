<?php namespace ss\crm\ui\controllers\bars;

class Info extends \Controller
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

        $s = &$this->s;

        if ($s['location'] == 'cat') {
            if ($cat = unpack_model(ap($s, 'locations/cat/data/cat'))) {
                $v->assign('cat', [
                    'TREE_NAME' => $cat->tree->name
                ]);

                $branch = ss()->cats->getNamesBranch($cat, false);

                foreach ($branch as $id => $name) {
                    $v->assign('cat/branch_node', [
                        'ID'   => $id,
                        'NAME' => $name
                    ]);
                }
            }

            // filter

            if ($filterVData = $this->getFilterVData()) {
                $v->assign('filter', $filterVData);
            }
        }

        if ($s['location'] == 'search') {
            $treesIds = ap($s, 'locations/search/data/trees_ids');

            if ($treesIds) {
                $treesNames = [];

                foreach ($treesIds as $treeId) {
                    if ($tree = \ss\models\Tree::find($treeId)) {
                        $treesNames[] = $tree->name;
                    }
                }

                $treesNames = implode(', ', $treesNames);
            } else {
                $treesNames = 'во всех ветках';
            }

            $v->assign('search', [
                'TREES_NAMES' => $treesNames
            ]);
        }

        $this->css();

        return $v;
    }

    private function getFilterVData()
    {
        $filterVData = false;

        $selectedDivisionId = ap($this->s, 'filters/multisource/division_id');

        $division = \ss\multisource\models\Division::find($selectedDivisionId);

        $filterVData['DIVISION'] = $division ? $division->name : '...';

        $selectedWarehouseId = ap($this->s, 'filters/multisource/warehouses_ids_by_divisions_ids/' . $selectedDivisionId);

        $warehouse = \ss\multisource\models\Warehouse::find($selectedWarehouseId);

        $filterVData['WAREHOUSE'] = $warehouse ? $warehouse->name : '...';

        if ($division || $warehouse) {
            return $filterVData;
        }
    }
}
