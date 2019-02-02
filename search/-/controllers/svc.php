<?php namespace ss\crm\search\controllers;

class Svc extends \Controller
{
    public $singleton = true;

    public $count = 0;

    private $treesByProducts = [];

    public function getTreeName(\ss\models\Product $product)
    {
        if (!isset($this->treesByProducts[$product->id])) {
            $this->treesByProducts[$product->id] = $product->tree;
        }

        return $this->treesByProducts[$product->id]->name;
    }
}
