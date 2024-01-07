<?php

use App\Models\User;
use Lite\Auth\Auth;
use Lite\Hash\Hash;
use Lite\Routing\Route;

Route::get("/", fn () => view("welcome"));

Route::get("/form", fn () => view("form"));

Route::get("/json", fn () => json([
    "test" => "ok"
]));

Route::get("/auth/register", fn () => view("/auth/register"));

Route::post("/auth/register", function ($request) {
    $data = $request->data();
    $data["password"] = Hash::make($data["password"]);
    $user = User::create($data);
    $user->login();
    return redirect("/");
});

Route::get("/auth/login", fn () => view("/auth/login"));

Route::post("/auth/login", function ($request) {
    $data = User::where("email", $request->data("email"));
    if (is_null($data) || count($data) == 0) {
        session()->flash("_errors", ["email" => ["email invalido!!!"]]);
        return back();
    }
    $user = User::parseModel($data[0]);
    if (!Hash::verify($request->data("password"), $user->password)) {
        session()->flash("_errors", ["password" => ["password invalido!!!"]]);
        return back();
    }
    $user->login();
    return redirect("/");
});

Route::get("/auth/logout", function ($request) {
    Auth::user()->logout();
    return redirect("/");
});
