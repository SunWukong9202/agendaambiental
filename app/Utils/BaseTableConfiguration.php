<?php 

namespace App\Utils;

use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Validation\ValidationException;

abstract class BaseTableConfiguration
{
    protected array $customColumns = [];
    protected array $customHeaderActions = [];
    protected array $customGroups = [];
    protected array $customFilters = [];
    protected array $customActions = [];
    protected array $customBulkActions = [];

    public function configure(Table $table): Table
    {
        // foreach($this->getDefaultOptions() as $method => $value) {
        //     $table->$method($value);
        // };

        return $table
            ->recordClasses('hover:bg-gray-100')
            ->headerActions($this->mergeDefaults($this->defaultHeaderActions(), $this->customHeaderActions))
            ->groups($this->mergeDefaults($this->defaultGroups(), $this->customGroups))
            ->columns($this->mergeDefaults($this->getDefaultColumns(), $this->customColumns))
            ->filters($this->mergeDefaults($this->getDefaultFilters(), $this->customFilters))
            ->actions($this->mergeDefaults($this->getDefaultActions(), $this->customActions))
            ->bulkActions($this->mergeDefaults($this->getDefaultBulkActions(), $this->customBulkActions));
    }

    public function setHeaderActions(array $actions): static
    {
        $this->customHeaderActions = $actions;

        return $this;
    }

    public function setCustomGroups(array $groups): static
    {
        $this->customGroups = $groups;

        return $this;
    }

    /**
     * Set custom columns to be merged with the defaults.
     */
    public function setColumns(array $columns): static
    {
        $this->customColumns = $columns;

        return $this;
    }

    /**
     * Set custom filters to be merged with the defaults.
     */
    public function setFilters(array $filters): static
    {
        $this->customFilters = $filters;
        return $this;
    }

    /**
     * Set custom actions to be merged with the defaults.
     */
    public function setActions(array $actions): static
    {
        $this->customActions = $actions;
        return $this;
    }

    /**
     * Set custom bulk actions to be merged with the defaults.
     */
    public function setBulkActions(array $bulkActions): static
    {
        $this->customBulkActions = $bulkActions;
        return $this;
    }

    /**
     * Merge defaults with custom configurations.
     */
    protected function mergeDefaults(array $defaults, array $custom): array
    {
        $defaults = array_filter($defaults, fn($value) => !is_null($value));
        $custom = array_filter($custom, fn($value) => !is_null($value));
        
        return array_merge($defaults, $custom);
    }

    
    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    // Abstract methods to be implemented by child classes
    abstract public function getDefaultOptions(): array;
    abstract public function defaultHeaderActions(): array;
    abstract public function defaultGroups(): array;
    abstract public function getDefaultColumns(): array;
    abstract public function getDefaultFilters(): array;
    abstract public function getDefaultActions(): array;
    abstract public function getDefaultBulkActions(): array;
}
