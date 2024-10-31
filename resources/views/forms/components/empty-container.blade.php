<div 
    {{ \Filament\Support\prepare_inherited_attributes($attributes)
        // ->merge([
        //     'id' => $getId(),
        // ], escape: false)
        ->merge($getExtraAttributes(), escape: false)
        ->merge($getExtraAlpineAttributes(), escape: false) }}
>
    {{ $getChildComponentContainer() }}
</div>
