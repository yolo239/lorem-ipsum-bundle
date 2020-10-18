<?php

namespace KnpU\LoremIpsumBundle\Event;

final class KnpULoremIpsumEvents
{
    /**
     * Called directly before the Lorem Ipsum API data is returned.
     *
     * blablablablab
     *
     * @Event("KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent")
     */
    const FILTER_API = 'knpu_lorem_ipsum.filter_api';
}