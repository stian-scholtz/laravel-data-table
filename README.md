# Laravel Data Tables Package

This headless Laravel package provides a convenient way to create and manage data tables in your Laravel applications. With support for various column types including boolean, date, enum, number, and text, it allows you to quickly set up and customize data tables to suit your needs.

## Features

- **Column Types:** Supports boolean, date, enum, number, and text columns.
- **Data Table Generation:** Includes a command to generate data tables with default boilerplate in the `app/DataTables` directory.
- **Search Filtering:** Support for filtering data based on the supplied search term.
- **Export Functionality:** Built-in functionality for easily exporting query results.

## Installation

You can install the package via Composer. Simply run the following command:

```bash
composer require stianscholtz/laravel-data-table
```

## Usage
### Generating Data Tables

To generate a data table, use the provided Artisan command:

```
php artisan make:data-table YourDataTableProvider
```

### Defining Data Tables

In your data table class, you define the query and columns. For example:

```php
use Illuminate\Contracts\Database\Query\Builder;
use Stianscholtz\LaravelDataTable\DataTableBuilder;
use Stianscholtz\LaravelDataTable\DataTableProvider;
use DB;

class YourDataTableProvider extends DataTableProvider
{
    protected bool $exportable = false;

    public function query(): Builder
    {
        /** @var Model $model */
        $model = request()->route('model');

        return DB::table('users')
        ->where('condition1', 'value')
        ->where('condition2', request('value'))
        ->when($model, fn(Builder $query) => $query->where('condition3', 'value'))
        ->select('users.id');//If you want to include the id in the data set.
    }

    public function columns(DataTableBuilder $builder): void
    {
        $builder->numberColumn('users.id', 'id', 'ID');

        if (!request()->route('model')) {
            $builder->textColumn('model.field', 'field', 'Field Name', false);
        }

        $builder->textColumn('users.name', 'user', 'User')
            ->enumColumn('users.status', 'status', 'Status')
            ->booleanColumn('IF(users.active, \'Yes\', \'No\')', 'active', 'Active')
            ->dateColumn('users.updated_at', 'updated_at', 'Updated At');
    }
}
```

### Controller

```php
public function index()
{
    return view('view.name', [
        'variable' => 'value',
        ...YourDataTableProvider::get(),
    ]);
    //OR
    return view('view.name', YourDataTableProvider::get(['variable' => 'value']));
}
```

### Filtering Data

The package automatically handles filtering data based on the supplied search term. Simply pass a 'term' in the request, and the package will filter the data accordingly.

### Exporting Data

The package automatically handles exporting data when $exportable is true and there is a 'export' key with a value of '1' in the request. The value of $exportable will also be available on the client side to determine if an export button should be visible.

## Contributing
Contributions are welcome! Please feel free to submit a pull request.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.