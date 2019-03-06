<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Tests;

use PHPUnit\Framework\TestCase;
use SymfonyNotes\ObjectTransformerBundle\Context\Context;
use SymfonyNotes\ObjectTransformerBundle\Transformer\CollectionObjectTransformer;
use SymfonyNotes\ObjectTransformerBundle\Transformer\ObjectTransformer;
use SymfonyNotes\ObjectTransformerBundle\Transformer\ObjectTransformerInterface;

/**
 * Class CollectionObjectTransformerTest.
 */
class CollectionObjectTransformerTest extends TestCase
{
    /**
     * @var ObjectTransformerInterface
     */
    private $objectTransformer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->objectTransformer = new ObjectTransformer();
        $this->objectTransformer->addObjectTransformer(new SourceToTargetObjectTransformer());

        $collectionObjectTransformer = new CollectionObjectTransformer($this->objectTransformer);

        $this->objectTransformer->addObjectTransformer($collectionObjectTransformer);
    }

    public function testTransform()
    {
        $objects = [
            new ObjectTransformerSourceObject(1),
            new ObjectTransformerSourceObject(2),
        ];

        $payload = 10;

        $transformed = $this
            ->objectTransformer
            ->transform($objects, ObjectTransformerTargetObject::class, new Context($payload));

        self::assertTrue(is_array($transformed));
        self::assertCount(2, $transformed);

        self::assertInstanceOf(ObjectTransformerTargetObject::class, $transformed[0]);
        self::assertInstanceOf(ObjectTransformerTargetObject::class, $transformed[1]);
        self::assertEquals(1, $transformed[0]->pr);
        self::assertEquals(10, $transformed[0]->pl);
        self::assertEquals(2, $transformed[1]->pr);
        self::assertEquals(10, $transformed[1]->pl);
    }
}
