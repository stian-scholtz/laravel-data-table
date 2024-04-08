<?php

namespace Stianscholtz\LaravelDataTable;

use Illuminate\Contracts\Database\Query\Builder;
use League\Csv\CannotInsertRecord;

abstract class DataTableProvider
{
    protected bool $exportable = false;

    /**
     * @return Builder
     */
    abstract public function query(): Builder;

    /**
     * @param DataTableBuilder $builder
     * @return void
     */
    abstract public function columns(DataTableBuilder $builder): void;

    /**
     * @param array $pageParameters
     * @return array
     * @throws CannotInsertRecord
     */
    public static function get(array $pageParameters = []): array
    {
        return [
            ...DataTable::forProvider(new static)->get(),
            ...$pageParameters,
        ];
    }

    public function exportable(): bool
    {
        return $this->exportable;
    }
}
