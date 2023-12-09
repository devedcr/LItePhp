<?php

namespace Lite;

use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;
use Lite\Http\Response;
use Lite\Routing\Router;
use Lite\Server\IServer;
use Lite\Server\ServerNative;

class App
{
    private Router $router;
    private IServer $iserver;

    public function __construct()
    {
        $this->router = new Router();
        $this->iserver = new ServerNative();
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function run()
    {
        try {
            $action = $this->router->resolve(new Request($this->iserver));
            $response = $action();
            $this->iserver->sendResponse($response);
        } catch (HttpNotFoundException $e) {
            $this->iserver->sendResponse(Response::text("Not Found")->setStatus(404));
        }
    }
}
