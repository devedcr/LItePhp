<?php

namespace Lite;

use Lite\Container\Container;
use Lite\Database\Driver\IDatabaseDriver;
use Lite\Database\Driver\PdoDriver;
use Lite\Http\HttpMethod;
use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;
use Lite\Http\Response;
use Lite\Routing\Router;
use Lite\Server\IServer;
use Lite\Server\ServerNative;
use Lite\Session\Session;
use Lite\Session\SessionNative;
use Lite\Validation\Exception\ValidationErrors;
use Lite\View\IViewEngine;
use Lite\View\ViewEngine;

class App
{
    public Router $router;
    public IServer $iserver;
    public IViewEngine $view;
    public Session $session;
    public IDatabaseDriver $database;

    public static function bootstrap(): self
    {
        $app = Container::singleton(self::class);
        $app->router = new Router();
        $app->iserver = new ServerNative();
        $app->view = new ViewEngine(__DIR__ . "/../view");
        $app->session = new Session(new SessionNative());
        $app->database = new PdoDriver();
        $app->database->connect("pgsql", "db_test", "127.0.0.1", 5432, "postgres", "edcr");
        return $app;
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function prepareNextRequest()
    {
        if ($this->iserver->requestMethod() == HttpMethod::GET)
            $this->session->set("_previous", $this->iserver->requestUri());
    }

    public function run()
    {
        try {
            $this->prepareNextRequest();
            $response = $this->router->resolve(new Request($this->iserver));
            $this->terminate($response);
        } catch (HttpNotFoundException $e) {
            $this->abort(text("Not Found")->setStatus(404));
        } catch (ValidationErrors $e) {
            if ($this->request_of_form()) {
                session()->flash("_errors", $e->getErrors());
                session()->flash("_old", $this->iserver->requestPost());
                return $this->abort(redirect("/form"));
            }
            $this->abort(json(["errors" => $e->getErrors()])->setStatus(422));
        }
    }

    public function request_of_form(): bool
    {
        $headers = $this->iserver->getHeaders();
        if (!isset($headers["Content-Type"]))
            return false;
        return  strtolower($headers["Content-Type"]) == "application/x-www-form-urlencoded";
    }

    public function terminate(Response $response)
    {
        $this->iserver->sendResponse($response);
    }

    public function abort(Response $response)
    {
        $this->iserver->sendResponse($response);
    }
}
