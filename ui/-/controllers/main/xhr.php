<?php namespace ss\crm\ui\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    private $cat;

    private $s;

    private $sCat;

    public function __create()
    {
        $this->s = &$this->s('~');

        if ($this->cat = $this->unxpackModel('cat')) {
            $this->sCat = &$this->s('~|cat-' . $this->cat->id);
        }
    }

    public function updateScroll()
    {
        $port = $this->data('port');

        $s = &$this->s('~');

        if ($s['location'] == 'cat') {
            if ($cat = unpack_model(ap($s, 'locations/cat/data/cat'))) {

            }
        }

        if ($s['location'] == 'search') {

        }

//        $dock = $this->data('dock');
//
//        if ($dock == 'center') {
//            ra($this->sCat, [
//                'docks/center/scroll_left' => $this->data('scroll_left'),
//                'docks/center/scroll_top'  => $this->data('scroll_top')
//            ]);
//        }
//
//        if (in($dock, 'left, right')) {
//            ra($this->s, [
//                'docks/' . $dock . '/scroll_left' => $this->data('scroll_left'),
//                'docks/' . $dock . '/scroll_top'  => $this->data('scroll_top')
//            ]);
//        }
    }
}
