@props([
    'attribute',
    'rules' => [], 
    'messages' => []
])

@php
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
        if (!empty($attribute)) {
            $transParams['attribute'] = $attribute;
        }

        // Build the translation key
        $ruleKey = "validation.$rule" . ($ruleModifier ? ".$ruleModifier" : '');

        // Add the rule and its message to the result array
        $rulesWithMessages[$fullRule] = trans("validation.$rule" . ($ruleModifier ? ".$ruleModifier" : ''), $transParams);
    }

    // Replace the original rules if we have any processed rules with messages
    if (!empty($rulesWithMessages)) {
        $rules = $rulesWithMessages;
    }
@endphp

<div 
    x-data="{
        rules: {{ json_encode($rules) }},
        messages: {{ json_encode($messages) }},
        errorMessage: null,
        validate(event) {
            this.errorMessage = null; 
            const value = event.target.value;
            console.log(this.rules, this.messages);

            for (const rule of Object.keys(this.rules)) {
                console.log('rule: ' + rule)
                if (!laravelRulePort(value, rule)) {
                    this.errorMessage = this.rules[rule] || 'Invalid input';
                    break; 
                }
            }
        }
    }"
>
    <input 
        type="text" 
        x-on:input="validate" 
        class="border rounded px-2 py-1"
    >

    <div class="text-red-500" x-show="errorMessage">
        <span x-text="errorMessage"></span>
    </div>
</div>
