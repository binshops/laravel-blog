<?php

namespace HessamCMS\Laravel\Fulltext;

interface SearchInterface
{
    public function run($search);

    public function runForClass($search, $class);

    public function searchQuery($search);
}
