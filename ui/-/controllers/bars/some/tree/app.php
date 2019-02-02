<?php namespace ss\crm\ui\controllers\bars\some\tree;

class App extends \Controller
{
    public function getQueryBuilder()
    {
        return \ss\models\Tree::orderBy('position');
    }
}
