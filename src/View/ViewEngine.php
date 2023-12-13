<?php

namespace Lite\View;

class ViewEngine implements IViewEngine
{
    private string $directory;
    private string $layoutDirectory;
    private string $annotationTag;
    private string $defaultLayout;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
        $this->layoutDirectory = "layout";
        $this->annotationTag = "@content";
        $this->defaultLayout = "main";
    }

    public function render(string $viewName,  array $params = [], string $layoutName = null): string
    {
        $layoutName = $layoutName ?? $this->defaultLayout;
        if (file_exists("{$this->directory}/{$this->layoutDirectory}/{$layoutName}.php")) {
            return str_replace($this->annotationTag, $this->loadHtml($viewName, $params), $this->renderLayout($layoutName, $params));
        }
        return $this->loadHtml($viewName, $params);
    }

    public function renderView(string $viewName, array $params)
    {
        return $this->loadHtml($viewName, $params);
    }

    public function renderLayout(string $layout, array $params)
    {
        return $this->loadHtml("layout/{$layout}", $params);
    }

    public function loadHtml(string $fileName, array $params)
    {
        foreach ($params as $varName => $value) {
            $$varName = $value;
        }
        ob_start();
        require_once "{$this->directory}/{$fileName}.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
