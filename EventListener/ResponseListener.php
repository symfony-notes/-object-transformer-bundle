<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use SymfonyNotes\ObjectTransformerBundle\Exception\UnsupportedExpectedContentTypeException;

/**
 * Class ResponseListener.
 */
class ResponseListener
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ResponseListener constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     *
     * @throws UnsupportedExpectedContentTypeException
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $object = $event->getControllerResult();
        $contentType = $event->getRequest()->getContentType();

        if (!in_array($contentType, ['xml', 'json'], true)) {
            throw new UnsupportedExpectedContentTypeException($contentType);
        }

        $responseData = $this->serializer->serialize($object, $contentType);

        $response = new Response($responseData);
        $response->headers->set('Content-Type', $contentType);

        $event->setResponse($response);
    }
}
