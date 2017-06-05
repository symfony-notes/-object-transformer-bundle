<?php

declare(strict_types = 1);

namespace SymfonyNotes\ObjectTransformerBundle\DependencyInjection\Compiler;

use GlobalGames\Component\ObjectTransformer\ObjectTransformerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ObjectTransformerCompilerPass
 * @package SymfonyNotes\ObjectTransformerBundle\DependencyInjection\Compiler
 */
class ObjectTransformerCompilerPass implements CompilerPassInterface
{
    /**
     * Object transformer service identifier.
     */
    const OBJECT_TRANSFORMER_SERVICE_ID = 'notes.object_transformer';

    /**
     * Object transformer tag.
     */
    const OBJECT_TRANSFORMER_TAG = 'notes.object_transformer';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::OBJECT_TRANSFORMER_SERVICE_ID)) {
            return;
        }

        $definition = $container->getDefinition(self::OBJECT_TRANSFORMER_SERVICE_ID);

        if (!is_a($definition->getClass(), ObjectTransformerInterface::class, true)) {
            throw new \RuntimeException(sprintf(
                'Supports only implementations of "%s" as object transformer.',
                ObjectTransformerInterface::class
            ));
        }

        $taggedServices = $container->findTaggedServiceIds(self::OBJECT_TRANSFORMER_TAG);
        $methodCalls = [];

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $tag) {
                $methodCalls[] = ['addObjectTransformer', [new Reference($id), isset($tag['priority']) ? $tag['priority'] : 0]];
            }
        }

        $definition->setMethodCalls(array_merge($methodCalls, $definition->getMethodCalls()));
    }
}