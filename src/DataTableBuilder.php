<?php

namespace Stianscholtz\LaravelDataTable;

use Stianscholtz\LaravelDataTable\Columns\Column;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @method DataTableBuilder numberColumn(string $selector, string $alias, string $header, bool $searchable = true)
 * @method DataTableBuilder textColumn(string $selector, string $alias, string $header, bool $searchable = true)
 * @method DataTableBuilder booleanColumn(string $selector, string $alias, string $header, bool $searchable = false)
 * @method DataTableBuilder dateColumn(string $selector, string $alias, string $header, bool $searchable = false)
 * @method DataTableBuilder enumColumn(string $selector, string $alias, string $header, bool $searchable = false)
 */
class DataTableBuilder implements Arrayable
{
    protected array $columns;

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return $this
     */
    public function __call(string $name, array $arguments)
    {
        $columnClass = __NAMESPACE__.'\Columns\\'.\Str::studly($name);

        return $this->column(new $columnClass(...$arguments));
    }

    /**
     * @param  Column  $column
     * @return $this
     */
    protected function column(Column $column): DataTableBuilder
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->columns;
    }
}