<?php

namespace Lite;

use Lite\Container\Container;
use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;
use Lite\Http\Response;
use Lite\Routing\Router;
use Lite\Server\IServer;
use Lite\Server\ServerNative;
use Lite\Validation\Exception\ValidationErrors;
use Lite\View\IViewEngine;
use Lite\View\ViewEngine;

class App
{
    public Router $router;
    public IServer $iserver;
    public IViewEngine $view;

    public static function bootstrap(): self
    {
        $app = Container::singleton(self::class);
        $app->router = new Router();
        $app->iserver = new ServerNative();
        $app->view = new ViewEngine(__DIR__ . "/../view");
        return $app;
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function run()
    {
        try {
            $response = $this->router->resolve(new Request($this->iserver));
            $this->iserver->sendResponse($response);
        } catch (HttpNotFoundException $e) {
            $this->abort(text("Not Found")->setStatus(404));
        } catch (ValidationErrors $e) {
            $this->abort(json(["errors" => $e->getErrors()])->setStatus(422));
        }
    }

    public function abort(Response $response)
    {
        $this->iserver->sendResponse($response);
    }
}
