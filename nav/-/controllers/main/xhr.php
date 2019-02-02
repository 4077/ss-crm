<?php namespace ss\crm\nav\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function selectCat()
    {
        if ($cat = \ss\models\Cat::find($this->data('cat_id'))) {
            \ss\crm\ui()->loadCat($cat);

            $this->s('\ss\crm\ui~:locations/cat/data/cat', pack_models($cat), RR);

            $this->c('\ss\crm\ui~:reload');
        }
    }
}
