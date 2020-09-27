<?php

namespace KnpU\LoremIpsumBundle;

interface WordProviderInterface
{
    /**
     * Returns fake text wordlist
     * @return array
     */
    public function getWordList(): array;
}