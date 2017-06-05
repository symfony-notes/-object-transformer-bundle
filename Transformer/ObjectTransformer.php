<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Transformer;

use SymfonyNotes\ObjectTransformerBundle\Context\ContextInterface;
use SymfonyNotes\ObjectTransformerBundle\Exception\UnsupportedTransformationException;

/**
 * Manages object transformers.
 */
class ObjectTransformer implements ObjectTransformerInterface
{
    /**
     * @var ObjectTransformerInterface[]
     */
    private $objectTransformers = [];

    /**
     * @var array
     */
    private $sortedObjectTransformers = [];

    /**
     * @param ObjectTransformerInterface $objectTransformer
     * @param int                        $priority
     *
     * @throws \RuntimeException
     *
     * @return $this|ObjectTransformerInterface
     */
    public function addObjectTransformer($objectTransformer, $priority = 0)
    {
        if (!$objectTransformer instanceof ObjectTransformerInterface) {
            throw new \RuntimeException(sprintf(
                'Object transformer should be an instance of "%s".',
                ObjectTransformerInterface::class
            ));
        }

        if (!isset($this->objectTransformers[$priority])) {
            $this->objectTransformers[$priority] = [];
        }

        $this->objectTransformers[$priority][] = $objectTransformer;
        $this->sortedObjectTransformers = null;

        return $this;
    }

    /**
     * @return ObjectTransformerInterface[]
     */
    public function getObjectTransformers()
    {
        if ($this->sortedObjectTransformers !== null) {
            return $this->sortedObjectTransformers;
        }

        krsort($this->objectTransformers);

        $this->sortedObjectTransformers = [];

        foreach ($this->objectTransformers as $modelTransformers) {
            $this->sortedObjectTransformers = array_merge($this->sortedObjectTransformers, $modelTransformers);
        }

        return $this->sortedObjectTransformers;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($object, $targetClass, ContextInterface $context = null): bool
    {
        if (null === $object) {
            // transformation of nothing ot anything is nothing
            return true;
        }

        foreach ($this->getObjectTransformers() as $modelTransformer) {
            if (($modelTransformer instanceof ObjectTransformerInterface) && $modelTransformer->supports($object, $targetClass, $context)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object, $targetClass, ContextInterface $context = null)
    {
        if (null === $object) {
            // transformation of nothing ot anything is nothing
            return null;
        }

        $modelTransformer = $this->findSupportedObjectTransformer($object, $targetClass, $context);

        if ($modelTransformer instanceof ObjectTransformerInterface) {
            return $modelTransformer->transform($object, $targetClass, $context);
        }

        $objectType = is_object($object) ? get_class($object) : gettype($object);

        throw new UnsupportedTransformationException($objectType, $targetClass);
    }

    /**
     * Finds and returns object transformer which supports specified object and target class.
     *
     * @param object|array          $object
     * @param string                $targetClass
     * @param ContextInterface|null $context
     *
     * @return null|ObjectTransformerInterface
     */
    public function findSupportedObjectTransformer($object, $targetClass, ContextInterface $context = null)
    {
        foreach ($this->getObjectTransformers() as $modelTransformer) {
            if (($modelTransformer instanceof ObjectTransformerInterface) && $modelTransformer->supports($object, $targetClass, $context)) {
                return $modelTransformer;
            }

            if ($modelTransformer instanceof ObjectTransformerInterface) {
                continue;
            }
        }

        return null;
    }
}
