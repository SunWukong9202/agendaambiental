@props([
    'label' => '',
    'hint' => '',
    'rules' => [],
    'messages' => []
])
{{-- //input.blade.php <x-input  rules="{{ $rules }}" :$rules :rules="$rules" /> --}}


{{-- <div x-data="{
    rules: {{ json_encode($rules) }},
    messages: {{ json_encode($messages) }},
    error: null,
    message: null,
    validate() {
        clearTimeout(this.error)
        for(rule in rules) {
            if(laravelRulePort($event.detail.value)) {
                this.message = messages[rule]
            }
        }
    }
}">
    <input type="text" x-on:input="validate">

    <div 
    class="text-red-500"
    x-effect="if(message) error = setTimeout(()=> message = null, 3000)" x-text="message">

    </div>
</div> --}}

<div class="flex items-center gap-x-3 justify-between">

    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="userData.email">


        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

            @if ($slot->isEmpty())
                {{ $label }}
            @else
                {{ $slot }}
            @endif

            <sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
        
        </span>


    </label>

    <div class="fi-fo-field-wrp-hint flex items-center gap-x-3 text-sm">
        <span class="fi-fo-field-wrp-hint-label text-gray-500 fi-color-gray" style="--c-400:var(--gray-400);--c-600:var(--gray-600);">
            @isset($hint)
                {{ $hint }}
            @endisset
        </span>
    </div>
</div>