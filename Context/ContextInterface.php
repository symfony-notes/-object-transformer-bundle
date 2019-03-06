<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Context;

/**
 * Interface for represents object transformation context.
 */
interface ContextInterface
{
    /**
     * @return mixed
     */
    public function getPayload();
}
