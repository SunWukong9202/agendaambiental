@props([
    'user'
])

<div class="grid gap-y-2">
    <x-fl.label>
        {{ __('form.name') }}
    </x-fl>
    <x-panel.alpine-validator
        attribute="{{ __('form.name') }}"
        :rules="['min:5|string', 'max:10|string', 'required']"
    >
        <x-filament::input.wrapper>
            <x-filament::input
                x-on:input="validate"
                type="text"
                {{-- wire:model="user.name" --}}
            />
        </x-filament>
    </x-panel>
</div>

<div class="grid gap-y-2">
    <x-fl.label>
        {{ __('form.key') }}
    </x-fl>
    <x-panel.alpine-validator
        attribute="{{ __('form.key') }}"
        :rules="['min:6|string', 'max:6|string', 'required']"
    >
        <x-filament::input.wrapper>
            <x-filament::input 
                type="number"
                maxlength="6"
                x-on:input="validate"
                {{-- wire:model="user.key" --}}
            />
        </x-filament>
    </x-panel>
</div>

<x-filament::input.wrapper>
    <x-filament::input 
        type="email"
        wire:model="user.email"
    />
</x-filament>

<x-filament::input.wrapper>
    <x-filament::input.select native wire:model="user.gender">
        @foreach (trans('form.genders') as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </x-filament::input.select>
</x-filament::input.wrapper>

