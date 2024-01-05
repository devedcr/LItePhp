<?php

namespace Lite;

use Dotenv\Dotenv;
use Lite\Config\Config;
use Lite\Container\Container;
use Lite\Database\Driver\IDatabaseDriver;
use Lite\Database\Model;
use Lite\Http\HttpMethod;
use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;
use Lite\Http\Response;
use Lite\Routing\Router;
use Lite\Server\IServer;
use Lite\Session\Session;
use Lite\Validation\Exception\ValidationErrors;

class App
{
    public static string $root;
    public Router $router;
    public IServer $iserver;
    public Session $session;
    public IDatabaseDriver $database;

    public static function bootstrap(string $root): self
    {
        self::$root = $root;
        $app = Container::singleton(self::class);

        return $app->loadfilesConfig()
            ->loadServiceProvider("boot")
            ->loadHttpHandler()
            ->upDatabase()
            ->loadServiceProvider("runtime");
    }

    public function loadfilesConfig(): self
    {
        Dotenv::createImmutable(self::$root)->load();
        Config::load(self::$root . "/config");
        return $this;
    }

    public function loadServiceProvider(string $name): self
    {
        foreach (config("provider.$name", []) as $provider) {
            $instance = new $provider();
            $instance->register_service();
        }
        return $this;
    }

    public function loadHttpHandler(): self
    {
        $this->router = app(Router::class);
        $this->iserver = app(IServer::class);
        $this->session = app(Session::class);
        return $this;
    }

    public function upDatabase(): self
    {
        $this->database = app(IDatabaseDriver::class);
        $this->database->connect(
            config("database.connection"),
            config("database.database"),
            config("database.host"),
            config("database.port"),
            config("database.username"),
            config("database.password")
        );
        Model::setDatabaseDriver($this->database);
        return $this;
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
