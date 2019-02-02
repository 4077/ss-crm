<?php namespace ss\crm\nav\controllers\main;

class App extends \Controller
{
    public function treeQueryBuilder()
    {
        if ($tree = $this->unpackModel('tree')) {
            return $tree->cats()->where('type', 'page')->orderBy('position');
//            return $tree->cats()->orderBy('position');
        }
    }

    public function treeReload()
    {
        $this->widget('~:', 'bind');
    }
}
