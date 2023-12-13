<?php

namespace Stianscholtz\LaravelDataTable\Columns;

class NumberColumn extends Column
{
    public function __construct(string $selector, string $alias, string $header, bool $searchable = true)
    {
        parent::__construct($selector, $alias, $header, $searchable);
    }
}