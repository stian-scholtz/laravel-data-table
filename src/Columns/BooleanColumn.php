<?php

namespace Stianscholtz\LaravelDataTable\Columns;

class BooleanColumn extends Column
{
    public function __construct(string $selector, string $alias, string $header, bool $searchable = false)
    {
        parent::__construct($selector, $alias, $header, $searchable);
    }
}