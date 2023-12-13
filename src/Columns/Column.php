<?php

namespace Stianscholtz\LaravelDataTable\Columns;

use Illuminate\Contracts\Support\Arrayable;

abstract class Column implements Arrayable
{
    protected string $dataType;

    protected string $selector;
    protected string $alias;
    protected string $header;
    protected bool $searchable;

    /**
     * @param  string  $selector
     * @param  string  $alias
     * @param  string  $header
     * @param  bool  $searchable
     */
    public function __construct(string $selector, string $alias, string $header, bool $searchable)
    {
        $this->setDataType();
        $this->selector = $selector;
        $this->alias = $alias;
        $this->header = $header;
        $this->searchable = $searchable;
    }

    /**
     * @return void
     */
    protected function setDataType(): void
    {
        $this->dataType = preg_replace('/column/', '', strtolower(class_basename(get_called_class())));
    }

    public function selector(): string
    {
        return $this->selector;
    }

    public function alias(): string
    {
        return $this->alias;
    }

    public function header(): string
    {
        return $this->header;
    }

    public function searchable(): bool
    {
        return $this->searchable;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'dataType' => $this->dataType,
            'selector' => $this->selector,
            'alias' => $this->alias,
            'header' => $this->header,
            'searchable' => $this->searchable,
        ];
    }
}