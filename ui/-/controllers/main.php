<?php namespace ss\crm\ui\controllers;

class Main extends \Controller
{
    private $s;

    private $sCat;

    public function __create()
    {
        $s = &$this->initSession();

        $location = $this->data('location');

        if ($location == 'cat') {
            $this->packModels();
            $this->smap(false, 'locations/cat/data/cat cat');
            $this->unpackModels();

            if (!$cat = $this->unpackModel('cat')) {
                if ($defaultTree = \ss\models\Tree::find($this->data('default_tree_id'))) {
                    $cat = ss()->trees->getRootCat($this->data('default_tree_id'));

                    $this->s(':locations/cat/data/cat', pack_model($cat), RR);
                }
            }

            $this->sCat = &$this->s('|cat-' . $cat->id, [
                'scroll_top'          => 0,
                'scroll_left'         => 0,
                'selected_product_id' => false
            ]);
        }

        if ($location == 'search') {

        }
    }

    private function getPortDefaultData($contentType)
    {
        return [
            'content_type' => $contentType,
            'scroll_top'   => 0,
            'scroll_left'  => 0,
            'visible'      => true
        ];
    }

    private function &initSession()
    {
        $this->smap(false, 'location');

        $this->s = &$this->s(false, [
            'location'  => false,
            'locations' => [
                'cat'    => [
                    'data'  => [
                        'cat'                 => false,
                        'selected_product_id' => false
                    ],
                    'ports' => [
                        'A' => $this->getPortDefaultData('cat'),
                        'B' => $this->getPortDefaultData('product'),
                        'C' => $this->getPortDefaultData('nav')
                    ]
                ],
                'search' => [
                    'data'  => [
                        'query'               => '',
                        'trees_ids'           => [],
                        'selected_product_id' => false
                    ],
                    'ports' => [
                        'A' => $this->getPortDefaultData('search'),
                        'B' => $this->getPortDefaultData('product'),
                        'C' => false
                    ]
                ],
            ],
            'bars'      => [
                'main' => [
                    'main_button' => 'search'
                ],
                'more' => [
                    'visible'       => false,
                    'selected_some' => false
                ],
                'some' => [
                    'visible' => false,
                    'content' => false // false|tree|filter|search
                ]
            ],
            'ordering'  => 'name',
            'filters'   => [
                'multisource' => [
                    'division_id'                     => 0,
                    'warehouses_ids_by_divisions_ids' => []
                ]
            ]
        ]);

        return $this->s;
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        pusher()->subscribe();

        $v = $this->v('|');

//        $cat = $this->cat;
//        $catXPack = xpack_model($cat);

        $class = [];

        if ($this->s['ordering'] == 'name') {
            $class[] = 'ordering_by_name';
        }

        $v->assign([
                       'CLASS'    => implode(' ', $class),
                       'MAIN_BAR' => $this->c('bars/main:view'), // ['cat' => $cat]),
                       'MORE_BAR' => $this->c('bars/more:view'), // ['cat' => $cat]),
                       'INFO_BAR' => $this->c('bars/info:view'), // ['cat' => $cat]),
                       'SOME_BAR' => $this->c('bars/some:view'), // ['cat' => $cat]),
                   ]);

        $mobile = 0;//$this->s['mobile'];

        $portATarget = 'CENTER_DOCK_CONTENT';
        $portBTarget = $mobile ? 'FS_LAYER_CONTENT' : 'RIGHT_DOCK_CONTENT';
        $portCTarget = $mobile ? 'CENTER_LAYER_CONTENT' : 'LEFT_DOCK_CONTENT';

        $portsViews = $this->portsViews();

        $v->assign([
                       $portATarget => $portsViews['A'],
                       $portBTarget => $portsViews['B'],
                       $portCTarget => $portsViews['C'],
                   ]);

        $this->css();
        $this->css('contentTags:vars');

        if ($css = $this->data('css')) {
            $this->css($css)->setVars(['__nodeId__' => $this->_nodeId()]);
        }

        $this->c('\std\ui\dialogs~:addThemeContainer:ss, \ss dialogsThemes/main');
        $this->c('\std\ui\dialogs~:addContainer:ss/cats');

        $docks = [];

//        ra($docks, $this->s['docks']);
//        $this->sCat['docks'] ?? false and ra($docks, $this->sCat['docks']);

//        $this->c('\plugins\perfectScrollbar~:bind', [
//            'selector' => $this->_selector('.port'),
//            'options'  => [
//
//            ]
//        ]);

        $this->widget(':|', [
            '.r' => [
                'updateScroll' => $this->_p('>xhr:updateScroll|')
            ],
            '.w' => [
                'mainBar' => $this->_w('bars/main:|'),
                'moreBar' => $this->_w('bars/more:|'),
                'someBar' => $this->_w('bars/some:|')
            ],
            //            'docks' => $docks
        ]);

        return $v;
    }

    public function portsViews()
    {
        $location = ap($this->s, 'location');
        $locationData = ap($this->s, 'locations/' . $location);

        $portsViews = [
            'A' => false,
            'B' => false,
            'C' => false
        ];

        foreach (['A', 'B', 'C'] as $port) {
            $portsViews[$port] = $this->c('\std\ui tag:view', [
                'attrs'   => [
                    'class' => 'port',
                    'port'  => $port
                ],
                'content' => $this->portView(
                    $locationData['ports'][$port]['content_type'],
                    $locationData['data']
                )
            ]);
        }

        return $portsViews;
    }

    public function portView($contentType, $data)
    {
        if ($contentType == 'search') {
            return $this->c('\ss\crm\search~:view', $data);
        }

        if ($contentType == 'cat') {
            return $this->c('\ss\crm\cat~:view', $data);
        }

        if ($contentType == 'product') {
            if ($selectedProductId = ap($this->sCat, 'selected_product_id')) {
                if ($product = \ss\models\Product::find($selectedProductId)) {
                    return $this->c('\ss\crm\product~:view', [
                        'product' => $product
                    ]);
                }
            }
        }

        if ($contentType == 'nav') {
            return $this->c('\ss\crm\nav~:view', $data);
        }
    }
}
