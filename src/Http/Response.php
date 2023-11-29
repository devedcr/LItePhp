<?php

namespace Lite\Http;

class Response
{
    public int $status = 200;
    public ?array $headers;
    public ?string $content;

    public function __construct()
    {
        $this->status = 200;
        $this->headers = null;
        $this->content = null;
    }

    public function status(): int
    {
        return $this->status;
    }
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function headers(): ?array
    {
        return $this->headers;
    }
    public function setHeader(string $name, string $value): self
    {
        $this->headers[strtolower($name)] = strtolower($value);
        return $this;
    }
    public function content(): ?string
    {
        return $this->content;
    }
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
    public static function json(array $data): self
    {
        return (new self())
            ->setHeader("content-type", "application/json")
            ->setContent(json_encode($data));
    }

    public static function text(string $text): self
    {
        return (new self())
            ->setHeader("content-type", "text/plain")
            ->setContent($text);
    }

    public static function html(string $html): self
    {
        return (new self())
            ->setHeader("content-type", "text/html")
            ->setContent($html);
    }

    public static function redirect(string $uri): self
    {
        return (new self())
            ->setStatus(302)
            ->setHeader("location", $uri);
    }
}
