<?php

namespace Lite\View;

interface IViewEngine
{
    public function render(string $viewName, array $params = [], string $layoutName=null): string;
}
