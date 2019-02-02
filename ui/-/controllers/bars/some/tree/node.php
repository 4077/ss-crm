<?php namespace ss\crm\ui\controllers\bars\some\tree;

class Node extends \Controller
{
    public function view()
    {
        $node = $this->unpackModel('node');

        $v = $this->v('|' . $node->id);

        $nodeXPack = xpack_model($node);

        $isRootNode = $this->data['root_node_id'] == $node->id;

        $v->assign([
                       'ID'              => $node->id,
                       'ROOT_CLASS'      => $isRootNode ? 'root' : '',
                       'SELECTED_CLASS'  => in($node->id, $this->data('selected_nodes_ids')) ? 'selected' : '',
                       'MODE_ICON_CLASS' => !$isRootNode ? 'fa fa-' . ($node->mode == 'folders' ? 'folder' : 'file') : 'hidden',
                       'NAME'            => $node->name ?: '...'
                   ]);

        $this->c('\std\ui button:bind', [
            'selector' => $this->_selector('|' . $node->id),
            'path'     => '>xhr:select|',
            'data'     => [
                'node' => $nodeXPack
            ]
        ]);

        $this->css(':\js\jquery\ui icons');

        return $v;
    }
}
