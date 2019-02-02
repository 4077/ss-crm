<?php namespace ss\crm\controllers;

class Router extends \Controller implements \ewma\Interfaces\RouterInterface
{
    public function getResponse()
    {
        $this->route('*')->to('ui router:getResponse', $this->data);

        return $this->routeResponse();
    }
}
