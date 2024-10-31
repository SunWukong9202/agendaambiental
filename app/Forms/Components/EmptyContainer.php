<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Component;
use Filament\Support\Concerns\HasExtraAlpineAttributes;


/**
 * EmptyContainer
 * 
 * The sole purpose of this class is apply alpine directives to form inputs/or other filament
 * components as whole given that when we add alpine directives/attributes with extraAttributes
 * method these apply only to the input not even to its label
 * 
 */
class EmptyContainer extends Component
{
    use HasExtraAlpineAttributes;

    protected string $view = 'forms.components.empty-container';

    public function __construct(array $childs)
    {
        $this->childComponents($childs);
    }

    public static function make(array $childs = []): static
    {
        return app(static::class, ['childs' => $childs]);
    }
}
