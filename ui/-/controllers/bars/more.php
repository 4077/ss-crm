<?php namespace ss\crm\ui\controllers\bars;

class More extends \Controller
{
    private $cat;

    private $s;

//    private $sCat;

    public function __create()
    {
//        if ($this->cat = $this->unpackModel('cat')) {
//            $this->instance_($this->cat->tree_id);

        $this->s = &$this->s('~');
//            $this->sCat = &$this->s('~|cat-' . $this->cat->id);
//        } else {
//            $this->lock();
//        }
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

//        $cat = $this->cat;
//        $catXPack = xpack_model($cat);

        $visible = ap($this->s, 'bars/more/visible');

        $v->assign([
                       'HIDDEN_CLASS' => $visible ? '' : 'hidden'
                   ]);

        $this->css();

        $this->widget(':|', [
//            '.payload'     => [
////                'cat' => $catXPack
//            ],
'.r'           => [
    'setVisibility'        => $this->_p('>xhr:setVisibility'),
    'setSomeBarVisibility' => $this->_p('>xhr:setSomeBarVisibility'),
    'selectSome'           => $this->_p('>xhr:selectSome'),
    'qrScan'               => $this->_p('>xhr:qrScan'),
    'toggleOrdering'       => $this->_p('>xhr:toggleOrdering')
],
'.w'           => [
    'mainBar' => $this->_w('@main:|'),
    'someBar' => $this->_w('@some:|')
],
'selectedSome' => ap($this->s, 'bars/more/selected_some')
        ]);

        return $v;
    }
}
