<?php namespace ss\crm\ui\controllers\bars\some\filter;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    private $s;

    public function __create()
    {
        $this->s = &$this->s('~');
    }

    public function selectDivision()
    {
        $divisionId = $this->data('value');

        ap($this->s, 'filters/multisource/division_id', $divisionId);

        if (!$divisionId) {
            ap($this->s, 'filters/multisource/warehouses_ids_by_divisions_ids/0', 0);
        }

        $this->app->session->save();

        $this->c('~:reload');
//        $this->c('<:reload');
//        $this->c('<cat~:reload');
//        $this->c('bars/info:reload');
    }

    public function selectWarehouse()
    {
        $divisionId = ap($this->s, 'filters/multisource/division_id');

        $warehouseId = $this->data('value');

        if (!$divisionId) {
            if ($warehouse = \ss\multisource\models\Warehouse::find($warehouseId)) {
                $divisionId = $warehouse->division_id;

                ap($this->s, 'filters/multisource/division_id', $divisionId);
            }
        }

        if ($divisionId) {
            ap($this->s, 'filters/multisource/warehouses_ids_by_divisions_ids/' . $divisionId, $warehouseId);
        }

        $this->app->session->save();

        $this->c('~:reload');
//        $this->c('<:reload', [], 'cat');
//        $this->c('<cat~:reload', [], 'cat');
//        $this->c('bars/info:reload', [], 'cat');
    }
}
