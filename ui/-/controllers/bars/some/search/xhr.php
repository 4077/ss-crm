<?php namespace ss\crm\ui\controllers\bars\some\search;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function updateSearchQuery()
    {
        $query = $this->data('value');

        $s = &$this->s('~');

        if ($s['location'] == 'cat') {
            if ($cat = unpack_model(ap($s, 'locations/cat/data/cat'))) {
                ap($s, 'locations/search/data/trees_ids', [$cat->tree_id]);
            } else {
                ap($s, 'locations/search/data/trees_ids', []);
            }
        }

        $s['location'] = 'search';

        ap($s, 'locations/search/data/query', $query);

        $this->c('~:reload');
    }
}
