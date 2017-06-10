<?php

declare(strict_types = 1);

namespace SymfonyNotes\ObjectTransformerBundle\Context;

/**
 * Represents object transformation context.
 */
class Context implements ContextInterface
{
    /**
     * @var mixed|null
     */
    private $payload;

    /**
     * @param mixed|null $payload
     */
    public function __construct($payload = null)
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed|null
     */
    public function getPayload()
    {
        return $this->payload;
    }
}
