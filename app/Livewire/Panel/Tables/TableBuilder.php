<?php 

namespace App\Livewire\Panel\Tables;

use Filament\Tables\Table;

class TableBuilder
{
    protected array $columns = [];
    protected array $filters = [];
    protected array $actions = [];
    protected array $bulkActions = [];
    protected array $options = [];
    protected $query;

    public static function make(): self
    {
        return new self();
    }

    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function filters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    public function actions(array $actions): self
    {
        $this->actions = $actions;
        return $this;
    }

    public function bulkActions(array $bulkActions): self
    {
        $this->bulkActions = $bulkActions;
        return $this;
    }

    public function applyDefaultsFromTrait($traitInstance): self
    {
        $this->columns = array_merge($traitInstance->getDefaultColumns(), $this->columns);
        $this->filters = array_merge($traitInstance->getDefaultFilters(), $this->filters);
        $this->actions = array_merge($traitInstance->getDefaultActions(), $this->actions);
        $this->bulkActions = array_merge($traitInstance->getDefaultBulkActions(), $this->bulkActions);

        $this->options = array_merge($traitInstance->getOptions(), $this->options);

        return $this;
    }   

    public function options($options): self
    {
        $this->options = $options;

        return $this;
    }

    protected function applyOptions(Table $table): void
    {
        foreach($this->options as $method => $value) {
            if(method_exists($table, $method)) {
                $table->$method($value);
            }
        }
    }

    public function build(Table $table): Table
    {

        $this->applyOptions($table);

        return $table
            ->columns($this->columns)
            ->filters($this->filters)
            ->actions($this->actions)
            ->bulkActions($this->bulkActions);
    }
}
