<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Tests;

use PHPUnit\Framework\TestCase;
use SymfonyNotes\ObjectTransformerBundle\Context\Context;
use SymfonyNotes\ObjectTransformerBundle\Exception\UnsupportedTransformationException;
use SymfonyNotes\ObjectTransformerBundle\Transformer\ObjectTransformer;
use SymfonyNotes\ObjectTransformerBundle\Transformer\ObjectTransformerInterface;

/**
 * Class ObjectTransformerTest.
 */
class ObjectTransformerTest extends TestCase
{
    /**
     * @var ObjectTransformerInterface
     */
    private $objectTransformer;

    protected function setUp()
    {
        parent::setUp();

        $this->objectTransformer = new ObjectTransformer();
        $this->objectTransformer->addObjectTransformer(new SourceToTargetObjectTransformer());
    }

    public function testTransform()
    {
        $object = new ObjectTransformerSourceObject(1);
        $payload = 10;

        $transformed = $this->objectTransformer->transform($object, ObjectTransformerTargetObject::class, new Context($payload));

        self::assertInstanceOf(ObjectTransformerTargetObject::class, $transformed);
        self::assertEquals(1, $transformed->pr);
        self::assertEquals(10, $transformed->pl);
    }

    public function testTransformWithException()
    {
        $this->expectException(UnsupportedTransformationException::class);

        $object = new ObjectTransformerSourceObject(1);

        $this->objectTransformer->transform($object, ObjectTransformerTargetObject2::class);
    }
}

class ObjectTransformerTargetObject2
{
}
