<?php namespace ss\crm\ui\controllers\bars\some;

class Search extends \Controller
{
//    private $cat;
//
//    private $s;
//
//    private $sCat;
//
//    public function __create()
//    {
//        if ($this->cat = $this->unpackModel('cat')) {
//            $this->instance_($this->cat->tree_id);
//
//            $this->s = &$this->s('~');
//            $this->sCat = &$this->s('~|cat-' . $this->cat->id);
//        } else {
//            $this->lock();
//        }
//    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $s = $this->s('~');

        $v->assign([
                       'SEARCH_QUERY' => htmlentities(ap($s, 'locations/search/data/query'))
                   ]);

        $this->css();

        $this->widget(':|', [
            '.r' => [
                'updateSearchQuery' => $this->_p('>xhr:updateSearchQuery')
            ]
        ]);

        return $v;
    }
}
