<?php

namespace Lite\Http;

/**
 * Response Class Server
 */
class Response
{
    /**
     * Response Status
     * @var integer
     */
    public int $status = 200;

    /**
     * Response Headers
     * @var array|null
     */
    public ?array $headers;

    /**
     * Response Content
     * @var string|null
     */
    public ?string $content;

    public function __construct()
    {
        $this->status = 200;
        $this->headers = null;
        $this->content = null;
    }

    /**
     * Getter Status Code
     * @return integer
     */
    public function status(): int
    {
        return $this->status;
    }
    
    /**
     * Setter Status
     * @param integer $status
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Getter Headers
     * @return array|null
     */
    public function headers(): ?array
    {
        return $this->headers;
    }

    /**
     * Setter Headers
     * @param string $name
     * @param string $value
     * @return self
     */
    public function setHeader(string $name, string $value): self
    {
        $this->headers[strtolower($name)] = strtolower($value);
        return $this;
    }

    /**
     * Getter Content
     *
     * @return string|null
     */
    public function content(): ?string
    {
        return $this->content;
    }

    /**
     * Setter content
     * @param string $content
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * Static Builder Response application/json
     * @param array $data
     * @return self
     */
    public static function json(array $data): self
    {
        return (new self())
            ->setHeader("content-type", "application/json")
            ->setContent(json_encode($data));
    }

    /**
     * Static Builder text/plain
     * @param string $text
     * @return self
     */
    public static function text(string $text): self
    {
        return (new self())
            ->setHeader("content-type", "text/plain")
            ->setContent($text);
    }

    /**
     * Static Builder text/html
     * @param string $html
     * @return self
     */
    public static function html(string $html): self
    {
        return (new self())
            ->setHeader("content-type", "text/html")
            ->setContent($html);
    }

    /**
     * Static Builder redirect uri
     * @param string $uri
     * @return self
     */
    public static function redirect(string $uri): self
    {
        return (new self())
            ->setStatus(302)
            ->setHeader("location", $uri);
    }
}
