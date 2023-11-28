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
    public function setStatus(int $status)
    {
        $this->status = $status;
    }
    public function headers(): ?array
    {
        return $this->headers;
    }
    public function setHeader(string $name, string $value)
    {
        $this->headers[strtolower($name)] = strtolower($value);
    }
    public function content(): ?string
    {
        return $this->content;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
