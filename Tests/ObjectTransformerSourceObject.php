<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Tests;

/**
 * This class is only for testing needs.
 */
class ObjectTransformerSourceObject
{
    /**
     * @var int
     */
    public $pr;

    /**
     * @param int $pr
     */
    public function __construct($pr)
    {
        $this->pr = $pr;
    }
}
