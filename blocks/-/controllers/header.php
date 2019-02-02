<?php namespace ss\crm\blocks\controllers;

class Header extends \Controller
{
    public function view()
    {
        $v = $this->v();

        $v->assign([
                       'INDEX_URL'    => abs_url(),
                       //                       'NAV'          => $this->c('\tdui\nav~:view', [], 'root_cat, cat, skip_cat_ids nav_skip_cat_ids'),
                       'SEARCH_QUERY' => $this->data('search_query')
                   ]);

        $this->css();

        $this->widget(':', [
            'paths' => [
                'updateSearchQuery' => $this->_p('>xhr:updateSearchQuery')
            ]
        ]);

        return $v;
    }

    public function loadSearchResults()
    {
        $this->jquery(".tdui_layouts__main .middle .content")->html($this->c('search:view', [
            'query' => $this->s(':search_query')
        ]));
    }
}
