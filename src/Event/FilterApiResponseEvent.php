<?php

namespace KnpU\LoremIpsumBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterApiResponseEvent extends Event
{
    private $data;

    /**
     * FilterApiResponseEvent constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }


}