<?php namespace ss\crm\ui\controllers\bars\some\tree\node;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function select()
    {
        if ($tree = $this->unxpackModel('node')) {
            $s = &$this->s('~');

            if ($s['location'] == 'cat') {
                $this->app->response->redirect('/cat/' . ss()->trees->getRootCat($tree->id)->id);

//            $this->c('~:reload', [
//                'cat' => ss()->trees->getRootCat($tree->id)
//            ]);
            }

            if ($s['location'] == 'search') {
                $treesIds = &ap($s, 'locations/search/data/trees_ids');

                toggle($treesIds, $tree->id);

                $this->c('<<:reload');
                $this->c('\ss\crm\search~:reload');

                \ss\crm\ui()->reloadInfoBar();
            }
        }
    }
}
