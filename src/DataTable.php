<?php

namespace Stianscholtz\LaravelDataTable;

use Stianscholtz\LaravelDataTable\Columns\Column;
use DB;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DataTable
{
    public DataTableProvider $provider;

    protected Builder $query;

    protected Collection $columns;

    protected ?string $term;

    protected bool $searchable = false;

    protected ?LengthAwarePaginator $list;

    /**
     * @param  DataTableProvider  $provider
     */
    public function __construct(DataTableProvider $provider)
    {
        $this->provider = $provider;
        $this->query = $this->provider->query();
        $this->setColumns();
        $this->term = request('term');
    }

    /**
     * @param  DataTableProvider  $provider
     * @return static
     */
    public static function forProvider(DataTableProvider $provider): static
    {
        return new static($provider);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $this->setColumns();

        $this->setSearchable();

        $this->applySearch();

        $this->select();

        $this->setList();

        return [
            'table' => [
                'list' => $this->list,
                'columns' => $this->columns,
                'searchable' => $this->searchable,
                'term' => $this->term,
            ]
        ];
    }

    /**
     * @return void
     */
    protected function setColumns(): void
    {
        $this->provider->columns($builder = new DataTableBuilder());

        $this->columns = collect($builder->toArray());
    }

    /**
     * @return void
     */
    protected function setSearchable(): void
    {
        $this->searchable = collect($this->columns)->contains(fn(Column $column) => $column->searchable());
    }

    /**
     * @return void
     */
    protected function applySearch(): void
    {
        $this->query
            ->when($this->term, fn($query) => $query->where(fn($query) => $this->columns
                ->filter(fn(Column $column) => $column->searchable())
                ->each(fn(Column $column) => $query->orWhere(DB::raw($column->selector()), 'like', '%'.$this->term.'%'))));
    }

    /**
     * @return void
     */
    protected function select(): void
    {
        $this->columns->each(fn(Column $column) => $this->query->addSelect(DB::raw($column->selector().' AS '.$column->alias())));
    }

    /**
     * @return void
     */
    protected function setList(): void
    {
        $this->list = $this->query->paginate()->withQueryString();
    }
}
