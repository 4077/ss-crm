<?php namespace ss\crm\ui\controllers\bars\more;

class Xhr extends \Controller
{
    public $allow = self::XHR;

//    private $cat;

    private $s;

//    private $sCat;

    public function __create()
    {
//        if ($this->cat = $this->unpackModel('cat')) {
//            $this->instance_($this->cat->tree_id);
//
        $this->s = &$this->s('~');
//            $this->sCat = &$this->s('~|cat-' . $this->cat->id);
//        } else {
//            $this->lock();
//        }
    }

    public function setVisibility()
    {
        $visible = &ap($this->s, 'bars/more/visible');

        $visible = $this->data('visible');
    }

    public function setSomeBarVisibility()
    {
        $visible = &ap($this->s, 'bars/some/visible');

        $visible = $this->data('visible');
    }

    public function selectSome()
    {
        $some = $this->data('some');

        ap($this->s, 'bars/more/selected_some', $some);
        ap($this->s, 'bars/some/visible', true);
        ap($this->s, 'bars/main/main_button', $some);

        $this->c('<<some:reload');//, ['cat' => $this->cat]);
    }

    public function qrScan()
    {
        $this->c('\plugins\instascan~:open', [
            'path' => $this->_p('~app:followQrCode')
        ]);
    }

    public function toggleOrdering()
    {
        ap($this->s, 'bars/main/main_button', 'ordering');

        $ordering = &ap($this->s, 'ordering');

        if ($ordering == 'name') {
            $ordering = 'position';
        } else {
            $ordering = 'name';
        }

        $this->app->response->reload();
    }
}
