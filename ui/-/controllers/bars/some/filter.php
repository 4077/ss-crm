<?php namespace ss\crm\ui\controllers\bars\some;

class Filter extends \Controller
{
    private $cat;

    private $s;

    private $sCat;

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

//        $cat = $this->cat;
//        $catXPack = xpack_model($cat);

        /// double
        $selectedDivisionId = ap($this->s, 'filters/multisource/division_id');

        $divisions = \ss\multisource\models\Division::orderBy('position')->get();

        if ($division = \ss\multisource\models\Division::find($selectedDivisionId)) {
            $warehouses = $division->warehouses()->orderBy('position')->get();
        } else {
            $warehouses = \ss\multisource\models\Warehouse::orderBy('position')->get();
        }
        ///

        $v->assign([
                       'DIVISION_SELECTOR'  => $this->c('\std\ui select:view', [
                           'path'     => '>xhr:selectDivision|',
                           //                           'data'     => [
                           ////                               'cat' => $catXPack
                           //                           ],
                           'items'    => [0 => 'Все подразделения'] + table_cells_by_id($divisions, 'name'),
                           'selected' => $selectedDivisionId
                       ]),
                       'WAREHOUSE_SELECTOR' => $this->c('\std\ui select:view', [
                           'path'     => '>xhr:selectWarehouse|',
                           //                           'data'     => [
                           ////                               'cat' => $catXPack
                           //                           ],
                           'items'    => [0 => 'Все склады'] + table_cells_by_id($warehouses, 'name'),
                           'selected' => ap($this->s, 'filters/multisource/warehouses_ids_by_divisions_ids/' . $selectedDivisionId)
                       ])
                   ]);

        $this->css();

        return $v;
    }
}
