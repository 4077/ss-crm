<?php namespace ss\crm\ui\controllers\bars;

class Some extends \Controller
{
    private $cat;

    private $s;

    private $sCat;

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

        $some = ap($this->s, 'bars/more/selected_some');

        $visible = ap($this->s, 'bars/some/visible');

        $v->assign([
                       'HIDDEN_CLASS' => $visible ? '' : 'hidden'
                   ]);


        if ($some) {
            $v->assign([
                           'CONTENT' => $this->c('>' . $some . ':view') // , ['cat' => $this->cat])
                       ]);
        }

        $this->css();

        $this->widget(':|');

        return $v;
    }
}
