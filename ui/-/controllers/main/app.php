<?php namespace ss\crm\ui\controllers\main;

class App extends \Controller
{
    public function followQrCode()
    {
        $url = $this->data('url');

        $this->app->response->href($url);
    }
}
