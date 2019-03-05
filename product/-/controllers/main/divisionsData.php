<?php namespace ss\crm\product\controllers\main;

class DivisionsData extends \Controller
{
    private $product;

    public function __create()
    {
        $this->product = $this->data('product');
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $product = $this->product;

        $divisionsById = table_rows_by_id(\ss\multisource\models\Division::orderBy('position')->get());
        $warehousesById = table_rows_by_id(\ss\multisource\models\Warehouse::orderBy('position')->get());

        $divisionsIds = array_keys($divisionsById);
        $warehousesIds = array_keys($warehousesById);

        $source = $product;

        do {
            $multisourceCache = _j($source->multisource_cache);
        } while (!$multisourceCache && $source = $source->source);

        $multisourceCache = map($multisourceCache, $divisionsIds);

        foreach ($multisourceCache as $divisionId => $divisionData) {
            if ($division = $divisionsById[$divisionId] ?? false) {
                $v->assign('division', [
                    'NAME'            => $division->name,
                    'PRICE'           => number_format__($divisionData['price'] ?? 0),
                    'TOTAL_STOCK'     => trim_zeros(number_format__($divisionData['total_stock'] ?? 0)),
                    'TOTAL_RESERVED'  => trim_zeros(number_format__($divisionData['total_reserved'] ?? 0)),
                    'TOTAL_AVAILABLE' => trim_zeros(number_format__(($divisionData['total_stock'] ?? 0) - ($divisionData['total_reserved'] ?? 0))),
                ]);

                if ($units = $product->units) {
                    $v->assign('division/units', [
                        'VALUE' => $units
                    ]);
                }

                if (isset($divisionData['warehouses'])) {
                    foreach (map($divisionData['warehouses'], $warehousesIds) as $warehouseId => $warehouseData) {
                        $warehouse = $warehousesById[$warehouseId];

                        $stock = $warehouseData['stock'] ?? 0;

                        if ($stock > 0) {
                            $v->assign('division/warehouse', [
                                'NAME'      => $warehouse->name,
                                'STOCK'     => trim_zeros(number_format__($stock)),
                                'RESERVED'  => trim_zeros(number_format__($warehouseData['reserved'] ?? 0)),
                                'AVAILABLE' => trim_zeros(number_format__($stock - ($warehouseData['reserved'] ?? 0))),
                            ]);
                        }
                    }
                }
            }
        }

        $v->assign([
                       'CONTENT' => false
                   ]);

        $this->css();

        return $v;
    }
}
