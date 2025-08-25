<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Component;
use Filament\Support\Concerns\HasExtraAlpineAttributes;

/**
 * ValidatorWrapper
 * 
 * the purpose of this component is to add laravel validations with alpine to show 
 * validations without send the form/input value to the server
 * 
 * note: the js port validator called in the view is in app.js
 * to make it globally accesible
 */
class AlpineValidator extends Component
{
    use HasExtraAlpineAttributes;

    protected string $view = 'forms.components.alpine-validator';

    private array $rules = [];
    private string $attribute;

    public function __construct(array $childs)
    {
        $this->childComponents($childs);
    }

    public static function make(array $childs = []): static
    {
        $static = app(static::class, ['childs' => $childs]);

        return $static;
    }

    public function getRules(): array
    {
        return $this->rules ?? [];
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function validationAttribute(string $name): static
    {
        $this->attribute = $name;

        return $this;
    }

    public function setRules(array $rules): static
    {
        $rulesWithMessages = [];

        foreach ($rules as $ruleSchema => $message) {
            
            // If both the rule schema and message are strings, break the loop
            if (is_string($ruleSchema) && is_string($message)) {
                break;
            }
            $ruleSchema = $message;
            
            // Check for rule modifier (e.g., 'min:5|required')
            $ruleModifier = '';
            if (strpos($ruleSchema, '|') !== false) {
                $ruleParts = explode('|', $ruleSchema);
                $fullRule = $ruleParts[0];  // First part of the rule (e.g., 'min:5')
                $ruleModifier = isset($ruleParts[1]) ? $ruleParts[1] : '';  // Second part (e.g., 'required')
            } else {
                $fullRule = $ruleSchema;  // No modifier, just the rule
            }
    
            // Check for rule value (e.g., 'min:5')
            $ruleValue = '';
            if (strpos($fullRule, ':') !== false) {
                $ruleValueParts = explode(':', $fullRule);
                $rule = $ruleValueParts[0];  // Rule type (e.g., 'min')
                $ruleValue = isset($ruleValueParts[1]) ? $ruleValueParts[1] : '';  // Rule value (e.g., '5')
            } else {
                $rule = $fullRule;  // No value, just the rule (e.g., 'required')
            }
    
            // Prepare translation parameters
            $transParams = [];
            if (!empty($ruleValue)) {
                $transParams[$rule] = $ruleValue;
            }
            if ($this->attribute) {
                $transParams['attribute'] = $this->attribute;
            }
    
            // Build the translation key
            $ruleKey = "validation.$rule" . ($ruleModifier ? ".$ruleModifier" : '');
    
            // Add the rule and its message to the result array
            $rulesWithMessages[$fullRule] = trans("validation.$rule" . ($ruleModifier ? ".$ruleModifier" : ''), $transParams);
        }
    
        // Replace the original rules if we have any processed rules with messages
        if (!empty($rulesWithMessages)) {
            $this->rules = $rulesWithMessages;
        }

        return $this;
    }
}
