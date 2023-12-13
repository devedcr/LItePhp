<?php

namespace Lite\View;

interface IViewEngine
{
    public function render(string $viewName): string;
}
