<?php

namespace Lite\Session;

class Session implements ISession
{
    public static string $FLASH = "_flash";
    public function __construct(private ISession $isession)
    {
        $this->isession = $isession;
        $this->isession->start();
    }

    public function __destruct()
    {
        $flashes = $this->get(self::$FLASH) ?? [];
        foreach ($flashes["old"] as $flash_old) {
            $this->remove($flash_old);
        }
        $flashes["old"] = $flashes["new"];
        $flashes["new"] = [];
        $this->set(self::$FLASH, $flashes);
    }

    public function flash(string $key, mixed $value): void
    {
        $flashes = $this->get(self::$FLASH, null);

        if (is_null($flashes))
            return;

        $this->set($key, $value);
        $flashes["new"][] = $key;
        $this->set(self::$FLASH, $flashes);
    }

    public function start(): void
    {
        $this->isession->start();
        $this->set(self::$FLASH, [
            "old" => $this->get(self::$FLASH, []),
            "new" => $this->get(self::$FLASH, []),
        ]);
    }

    public function id(): string
    {
        return $this->isession->id();
    }

    public function set(string $key, mixed $value): void
    {
        $this->isession->set($key, $value);
    }
    public function get(string $key, $default = null): mixed
    {
        return $this->isession->get($key, $default);
    }
    public function has(string $key): bool
    {
        return $this->isession->has($key);
    }
    public function remove(string $key): void
    {
        $this->isession->remove($key);
    }
}
