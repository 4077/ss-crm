<?php namespace ss\crm\ui\controllers\bars;

class Main extends \Controller
{
    private $s;

    public function __create()
    {
        $this->s = &$this->s('~');
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        //
        $mainButton = ap($this->s, 'bars/main/main_button');
        $moreButtons = l2a('ordering, tree, filter, search, qrcode');
        $moreButtonsLeft = array_search($mainButton, $moreButtons) * -60;
        //

        $s = $this->s('~');

        $backButtonHiddenClass = 'hidden';
        $closeButtonHiddenClass = 'hidden';

        if ($s['location'] == 'cat') {
            if ($cat = unpack_model(ap($s, 'locations/cat/data/cat'))) {
                $parent = $cat->parent;

                $backButtonHiddenClass = $parent ? '' : 'hidden';
            }
        }

        if ($s['location'] == 'search') {
            $backButtonHiddenClass = 'hidden';
            $closeButtonHiddenClass = '';
        }

        $v->assign([
                       'MORE_BUTTONS_LEFT'         => $moreButtonsLeft,
                       'MAIN_BUTTON_SOME'          => $mainButton,
                       'BACK_BUTTON_HIDDEN_CLASS'  => $backButtonHiddenClass,
                       'CLOSE_BUTTON_HIDDEN_CLASS' => $closeButtonHiddenClass
                   ]);

        $this->css();

        $this->widget(':|', [
            '.r'          => [
                'back'          => $this->_p('>xhr:back'),
                'close'         => $this->_p('>xhr:close'),
                'setMainButton' => $this->_p('>xhr:setMainButton')
            ],
            '.w'          => [
                'main'    => $this->_w('~:|'),
                'moreBar' => $this->_w('@more:|'),
            ],
            'moreButtons' => $moreButtons
        ]);

        return $v;
    }
}
