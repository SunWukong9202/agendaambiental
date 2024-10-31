<div 
    data-alpine-validator
    x-data="{
        rules: {{ json_encode($getRules()) }},
        errorMessage: null,
    
        validate(event) {
            this.errorMessage = null; 
            const wrapper = event.target.closest('.fi-input-wrp') 
            console.log(wrapper)
            const value = event.target.value;
            
            //console.log(this.rules, this.messages);
            
            for (const rule of Object.keys(this.rules)) {
                //console.log('rule: ' + rule)
                if (!laravelRulePort(value, rule, event.targe, this.rules[rule])) {
                
                    wrapper?.classList.remove('dark:ring-white/20', 'ring-gray-950/10'); 
                    wrapper?.classList.add('ring-danger-600', 'dark:ring-danger-500');

                    wrapper?.classList.remove('dark:[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-500', '[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-600');
                    
                    wrapper?.classList.add('dark:[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-danger-500', '[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-danger-600');
                    
                    this.errorMessage = this.rules[rule] || 'Invalid input';
                    return false; 
                } else {
                                    
                    wrapper?.classList.add('dark:ring-white/20', 'ring-gray-950/10'); 
                    wrapper?.classList.remove('dark:ring-danger-500', 'ring-danger-600'); 
                    
                    wrapper?.classList.remove('dark:[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-danger-500', '[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-danger-600');
                    
                    wrapper?.classList.add('dark:[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-500', '[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-600');
                }
            } 
            return true;
        },
        
    
    }"   
    
    {{ \Filament\Support\prepare_inherited_attributes($attributes)
        // ->merge([
        //     'id' => $getId(),
        // ], escape: false)
        ->merge($getExtraAttributes(), escape: false)
        ->merge($getExtraAlpineAttributes(), escape: false) }}
>
    {{ $getChildComponentContainer() }}

    <div class="fi-fo-field-wrp-error-message text-sm text-danger-600 dark:text-danger-400 mt-2" 
    {{-- aria-live="polite" --}}
    x-show="errorMessage">
        <span x-text="errorMessage"></span>
    </div>
</div>
