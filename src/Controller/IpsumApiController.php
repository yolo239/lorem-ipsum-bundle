<?php

namespace KnpU\LoremIpsumBundle\Controller;

use KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent;
use KnpU\LoremIpsumBundle\Event\KnpULoremIpsumEvents;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class IpsumApiController extends AbstractController
{
    /**
     * @var KnpUIpsum
     */
    private $knpUIpsum;

    private $eventDispatcher;

    /**
     * IpsumApiController constructor.
     * @param KnpUIpsum $knpUIpsum
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(KnpUIpsum $knpUIpsum, EventDispatcherInterface $eventDispatcher = null)
    {
        $this->knpUIpsum = $knpUIpsum;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function index()
    {
        $data = [
            'paragraphs' => $this->knpUIpsum->getParagraphs(),
            'sentences' => $this->knpUIpsum->getSentences()
        ];

        $event = new FilterApiResponseEvent($data);
        // dispatcher is optional
        if($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(KnpULoremIpsumEvents::FILTER_API, $event);
        }

        return $this->json($event->getData());
    }
}