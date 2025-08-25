<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Get;
use Illuminate\Contracts\Support\Htmlable;

class Alert extends Component
{
    protected string $view = 'forms.components.alert';
    protected $type = 'Success';
    protected string|Closure $description = '';
    protected $title = '';
    protected $list = [];
    protected $open = true;

    public function __construct(array $childs)
    {
        $this->childComponents($childs);
    }

    public static function make(array $childs = []): static
    {
        return app(static::class, ['childs' => $childs]);
    }

    public function description(string|Closure $value): static
    {
        
        $this->description = $value;

        return $this;
    }

    public function getDescription()
    {
        $description = $this->evaluate($this->description);

        return $description;
    }

    // public function getLabel(): string | Htmlable | null
    // {
    //     $label = $this->evaluate($this->label);

    //     return (is_string($label) && $this->shouldTranslateLabel) ?
    //         __($label) :
    //         $label;
    // }

    public function open(): self
    {
        $this->open = true;

        return $this;
    }

    public function getOpen(): bool
    {
        return $this->open;
    }

    public function closed(): self
    {
        $this->open = false;

        return $this;
    }

    public function addListOption($option): static
    {
        $this->list[] = $option;

        return $this;
    }

    public function getList(): array
    {
        return $this->list;
    }

    public function title($value): static
    {
        $this->title = $value;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function success(): static
    {
        $this->type = 'Success';

        return $this;
    }

    public function danger(): static
    {
        $this->type = 'Danger';

        return $this;
    }

    public function warning(): static
    {
        $this->type = 'Warning';

        return $this;
    }

    public function info(): static
    {
        $this->type = 'Info';

        return $this;
    }
}

