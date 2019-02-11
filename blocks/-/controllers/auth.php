<?php namespace ss\crm\blocks\controllers;

class Auth extends \Controller
{
    public function view()
    {
        if (!$this->_user()) {
            return $this->c('\std\ui\auth smsInvite:view', [
                'redirect' => [
                    'url'  => abs_url('c'),
                    'code' => 302
                ]
            ]);
        }
    }
}
