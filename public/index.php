<?php

require_once "../vendor/autoload.php";

use Lite\App;
use Lite\Database\DB;
use Lite\Database\Model;
use Lite\Http\Request;
use Lite\Routing\Route;

$app = App::bootstrap(__DIR__ . "/../");

Route::get("/hello", function () {
    return json([
        "code" => "test",
        "host" => env("APP_URL"),
        "port" => env("DB_PORT")
    ])->setStatus(201);
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

class User extends Model
{
    protected array $fillable = ["name", "email"];
}

Route::post("/user/create", function (Request $request) {
    $request->validate([
        "name" => ["required"],
        "email" => ["required", "email"]
    ]);

    //DB::statement("insert into users(name,email) values (:name,:email);", $request->data());

    $user = new User();
    $user->name = $request->data("name");
    $user->email = $request->data("email");
    $user->save();

    return json([
        "ok" => true
    ]);
});

Route::get("/user/list", function (Request $request) {
    return json([
        "ok" => true,
        "data" => DB::statement("select*from users")
    ]);
});

Route::post("/user/test", function (Request $request) {
    return json([
        "ok" => true,
        "data" => User::create([
            "name" => $request->data("name"),
            "email" => $request->data("email"),
        ])->toArray()
    ]);
});



$app->run();
