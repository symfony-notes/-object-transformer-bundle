<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Tests;

/**
 * This class is only for testing needs.
 */
class ObjectTransformerTargetObject
{
    /**
     * @var int
     */
    public $pr;

    /**
     * @var int
     */
    public $pl;

    /**
     * @param int $pr
     * @param int $pl
     */
    public function __construct($pr, $pl)
    {
        $this->pr = $pr;
        $this->pl = $pl;
    }
}
