<?php namespace ss\crm\ui\controllers\bars\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function back()
    {
        $s = &$this->s('~');

        if ($s['location'] == 'cat') {
            if ($cat = unpack_model(ap($s, 'locations/cat/data/cat'))) {
                if ($parent = $cat->parent) {
                    \ss\crm\ui()->loadCat($parent);

                    ap($s, 'locations/cat/data/cat', pack_models($parent));

                    $this->c('~:reload'); // todo убрать
                }
            }
        }

        if ($s['location'] == 'search') {
            $s['location'] = 'cat';

            $this->c('~:reload');
        }
    }

    public function close()
    {
        $s = &$this->s('~');

        if ($s['location'] == 'cat') {

        }

        if ($s['location'] == 'search') {
            $s['location'] = 'cat';

            $this->c('~:reload');
        }
    }

    // todo govnocode

    public function setMainButton()
    {
        $left = $this->data('left');

        $someByLeft = [
            -240 => 'qrcode',
            -180 => 'search',
            -120 => 'filter',
            -60  => 'tree',
            0    => 'ordering'
        ];

        if ($some = $someByLeft[$left] ?? false) {
            $this->s('~:bars/main/main_button', $some, RR);
        }
    }
}
