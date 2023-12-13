<?php

namespace Lite\View;

class ViewEngine implements IViewEngine
{
    private string $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function render(string $viewName): string
    {
        ob_start();
        require_once "{$this->directory}/{$viewName}.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
