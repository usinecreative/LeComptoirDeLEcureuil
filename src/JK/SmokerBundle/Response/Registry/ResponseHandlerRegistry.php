<?php

namespace App\JK\SmokerBundle\Response\Registry;

use App\JK\SmokerBundle\Exception\Exception;
use App\JK\SmokerBundle\Response\Handler\ResponseHandlerInterface;

class ResponseHandlerRegistry
{
    protected $registry = [];

    public function add(string $name, ResponseHandlerInterface $handler): void
    {
        $this->registry[$name] = $handler;
    }

    public function get(string $name): ResponseHandlerInterface
    {
        if (!$this->has($name)) {
            throw new Exception('The response handler "'.$name.'" was not found');
        }

        return $this->registry[$name];
    }

    public function has(string $name): bool
    {
        return key_exists($name, $this->registry);
    }

    /**
     * @return ResponseHandlerInterface[]
     */
    public function all(): array
    {
        return $this->registry;
    }
}
