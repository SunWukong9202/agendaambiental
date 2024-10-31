<x-slot:title>
    {{ __('pages.list users') }}
</x-slot>

<div>

    {{-- <form 
    wire:submit="save" class="flex flex-col gap-4">
        {{ $this->userForm }}   

        <x-filament::button type="submit" class="w-full">
            {{ true ? __('form.save') : __('form.create')}}
        </x-filament>
    </form> --}}

    {{ $this->table }}
</div>

{{-- <form 

    x-data="{
        receivedSenders: new Set(),
        allSenders: new Set(['key', 'email', 'name']),

        checkValidatedUser(event) {
            console.log('sender: ' + event.detail.sender + ' received')
            this.receivedSender.add(event.detail.sender)

            if(!event.detail.valid) return;

            if(this.checkAllSendersClicked()) {
                this.receivedSenders.clear();
                $wire.save;
            }
        },
        
        checkAllSendersClicked() {
            // Check if all required senders are in the received senders
            return [...this.allSenders].every(sender => this.receivedSenders.has(sender));
        },

        issueValidation(event) {
            console.log('validation issued')
            event.preventDefault();
            this.$dispatch('validateUser', console.log('sended issue'))
        }
    }"
    x-on:validatedUser="checkValidatedUser"
    x-on:submit="issueValidation" class="flex flex-col gap-4">
        {{ $this->userForm }}   

        <x-filament::button type="submit" class="w-full">
            {{ true ? __('form.save') : __('form.create')}}
        </x-filament>
    </form>
     --}}
{{-- 
@script
<script>
    let email = mail;

    let messages = (event) => {
        if(email.validity.valueMissing) {
            email.setCustomValidity("Por favor llene este campo")
        } else if (email.validity.typeMismatch) {
            email.setCustomValidity("Ingrese una direccion valida")
        } else {
            email.setCustomValidity("")
        }
    }
    window.addEventListener('DOMContentLoaded', () => {
        email.addEventListener('input', messages)
        email.addEventListener('mouseenter', () => {
            const customTitle = email.title || ''; // Default to existing title if any
            email.title = replacePlaceholders(customTitle, {
                min: email.min,
                max: email.max,
                minlength: email.minLength,
                maxlength: email.maxLength
            });
        })
        messages();
    })
    
</script>
@endscript --}}
