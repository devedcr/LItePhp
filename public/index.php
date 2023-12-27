<?php

require_once "../vendor/autoload.php";

use Lite\App;
use Lite\Http\Request;
use Lite\Routing\Route;

$app = App::bootstrap();


Route::get("/hello", function () {
    return json(["code" => "test"])->setStatus(201);
});

Route::get("/test/{id}/preuba/{title}", function () {
    return text("test param");
});

$app->router()->post("/hello", function () {
    return text("hello post");
});

Route::get("/redirect", function () {
    return redirect("/hello");
});

Route::get("/html", function () {
    return view("welcome", ["name" => "eduardo", "email" => "ed@ed.com"]);
});

Route::post("/save", function (Request $request) {
    return json($request->validate([
        "name" => "required",
        "email" => ["required", "email"],
        "test" => "required"
    ]));
});

Route::get("/session", function (Request $request) {
    session()->flash("alert", "test alert");
    return json([
        "id" => session()->id(),
        "test" => $_SESSION
    ]);
});

Route::get("/form", function (Request $request) {
    return view("form");
});

Route::post("/form", function (Request $request) {
    $request->validate([
        "email" => ["required", "email"],
        "name" => ["required"]
    ]);
    return json([
        "status" => "ok"
    ]);
});


$app->run();
