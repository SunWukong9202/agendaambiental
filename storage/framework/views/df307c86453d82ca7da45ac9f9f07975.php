<?php if (isset($component)) { $__componentOriginald4c772c02301431d3253f64117700596 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald4c772c02301431d3253f64117700596 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.base','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layouts.base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
        $permission = \App\Enums\Permission::class;
    ?>

    <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => ['class' => 'fixed top-0 z-30']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'fixed top-0 z-30']); ?>
        
            <div class="ml-auto flex gap-8">

                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('notifications-trigger');

$__html = app('livewire')->mount($__name, $__params, 'lw-2151777176-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                <?php if (isset($component)) { $__componentOriginal22ab0dbc2c6619d5954111bba06f01db = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22ab0dbc2c6619d5954111bba06f01db = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.index','data' => ['placement' => 'bottom-start']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placement' => 'bottom-start']); ?>
                     <?php $__env->slot('trigger', null, []); ?> 
                        
                        <button type="button" class="ml-auto px-[9px] py-2 rounded-full bg-white dark:bg-gray-950 shadow-sm border-primary-600 dark:border-primary-400 border-4 flex items-center justify-center ring-0">
                            AG
                        </button>
                     <?php $__env->endSlot(); ?>

                    <?php if (isset($component)) { $__componentOriginal66687bf0670b9e16f61e667468dc8983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66687bf0670b9e16f61e667468dc8983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::dropdown.list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.item','data' => ['class' => 'hover:bg-none cursor-text','icon' => 'heroicon-m-user-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::dropdown.list.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'hover:bg-none cursor-text','icon' => 'heroicon-m-user-circle']); ?>
                            <?php echo e(auth()->user()->name ?? 'Usuario'); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $attributes = $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $component = $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>

                        <div class="p-1 flex gap-1" @click="close()">
                            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['@click' => 'applyTheme(saveTheme(\'dark\'))','class' => 'flex-1 !ring-0 shadow-none','color' => 'gray','tooltip' => ''.e(__('Enable dark mode')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['@click' => 'applyTheme(saveTheme(\'dark\'))','class' => 'flex-1 !ring-0 shadow-none','color' => 'gray','tooltip' => ''.e(__('Enable dark mode')).'']); ?>
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-moon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-5 text-gray-400','x-bind:class' => 'theme == \'dark\' ? \'text-primary-600 dark:text-primary-400\' : \'\' ']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['@click' => 'applyTheme(saveTheme(\'light\'))','class' => 'flex-1 !ring-0 shadow-none','color' => 'gray','tooltip' => ''.e(__('Enable light mode')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['@click' => 'applyTheme(saveTheme(\'light\'))','class' => 'flex-1 !ring-0 shadow-none','color' => 'gray','tooltip' => ''.e(__('Enable light mode')).'']); ?>
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-sun'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-5 text-gray-400 b','x-bind:class' => 'theme == \'light\' ? \'text-primary-600 dark:text-primary-400\' : \'\' ']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['@click' => 'applyTheme(saveTheme(\'system\'))','class' => 'flex-1 !ring-0 shadow-none','color' => 'gray','tooltip' => ''.e(__('Enable system mode')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['@click' => 'applyTheme(saveTheme(\'system\'))','class' => 'flex-1 !ring-0 shadow-none','color' => 'gray','tooltip' => ''.e(__('Enable system mode')).'']); ?>
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-computer-desktop'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-5 text-gray-400','x-bind:class' => 'theme == \'system\' ? \'text-primary-600 dark:text-primary-400\' : \'\'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                        </div>

                        <div class="p-1">
                            
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('panel.language-switcher', ['@change' => 'close()','currentUrl' => ''.e(request()->url()).'']);

$__html = app('livewire')->mount($__name, $__params, 'lw-2151777176-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        </div>

                        <?php if (isset($component)) { $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.item','data' => ['tag' => 'a','wire:navigate' => true,'href' => ''.e(route('home')).'','icon' => 'heroicon-m-cog-6-tooth']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::dropdown.list.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'a','wire:navigate' => true,'href' => ''.e(route('home')).'','icon' => 'heroicon-m-cog-6-tooth']); ?>
                            <?php echo e(__('Settings')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $attributes = $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $component = $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.item','data' => ['tag' => 'a','wire:navigate' => true,'href' => ''.e(route('home')).'','icon' => 'heroicon-m-arrow-left']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::dropdown.list.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'a','wire:navigate' => true,'href' => ''.e(route('home')).'','icon' => 'heroicon-m-arrow-left']); ?>
                            <?php echo e(__('Return to home')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $attributes = $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $component = $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.item','data' => ['tag' => 'a','wire:navigate' => true,'href' => ''.e(route('logout')).'','icon' => 'heroicon-m-arrow-left-end-on-rectangle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::dropdown.list.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'a','wire:navigate' => true,'href' => ''.e(route('logout')).'','icon' => 'heroicon-m-arrow-left-end-on-rectangle']); ?>
                            <?php echo e(__('Log out')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $attributes = $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $component = $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66687bf0670b9e16f61e667468dc8983)): ?>
<?php $attributes = $__attributesOriginal66687bf0670b9e16f61e667468dc8983; ?>
<?php unset($__attributesOriginal66687bf0670b9e16f61e667468dc8983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66687bf0670b9e16f61e667468dc8983)): ?>
<?php $component = $__componentOriginal66687bf0670b9e16f61e667468dc8983; ?>
<?php unset($__componentOriginal66687bf0670b9e16f61e667468dc8983); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22ab0dbc2c6619d5954111bba06f01db)): ?>
<?php $attributes = $__attributesOriginal22ab0dbc2c6619d5954111bba06f01db; ?>
<?php unset($__attributesOriginal22ab0dbc2c6619d5954111bba06f01db); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22ab0dbc2c6619d5954111bba06f01db)): ?>
<?php $component = $__componentOriginal22ab0dbc2c6619d5954111bba06f01db; ?>
<?php unset($__componentOriginal22ab0dbc2c6619d5954111bba06f01db); ?>
<?php endif; ?>
            </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal91c821ac63991f310c0b8692f4f16f0a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91c821ac63991f310c0b8692f4f16f0a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.aside','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('aside'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php if (isset($component)) { $__componentOriginal32f1c3cbb504341c40b1a5cc46044f53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.dashboard'),'active' => request()->routeIs('admin.dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.dashboard'))]); ?>
                 <?php $__env->slot('icon', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-squares-2x2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>
                <?php echo e(__('ui.pages.Dashboard')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53)): ?>
<?php $attributes = $__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53; ?>
<?php unset($__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32f1c3cbb504341c40b1a5cc46044f53)): ?>
<?php $component = $__componentOriginal32f1c3cbb504341c40b1a5cc46044f53; ?>
<?php unset($__componentOriginal32f1c3cbb504341c40b1a5cc46044f53); ?>
<?php endif; ?>

        <?php if (\Illuminate\Support\Facades\Blade::check('cananyCM', [
            $permission::ViewUsers->value,
            $permission::ViewSuppliers->value,
            $permission::ViewRoles->value
        ])): ?>
            <?php if (isset($component)) { $__componentOriginal32f1c3cbb504341c40b1a5cc46044f53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.index','data' => ['persisted' => true,'initiallyOpen' => true,'key' => ''.e(__('ui.pages.Users Managment')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['persisted' => true,'initiallyOpen' => true,'key' => ''.e(__('ui.pages.Users Managment')).'']); ?>
                 <?php $__env->slot('trigger', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginal8f4210c6fcc505e0e2984540f29432bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f4210c6fcc505e0e2984540f29432bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php echo e(__('ui.pages.Users Managment')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f4210c6fcc505e0e2984540f29432bc)): ?>
<?php $attributes = $__attributesOriginal8f4210c6fcc505e0e2984540f29432bc; ?>
<?php unset($__attributesOriginal8f4210c6fcc505e0e2984540f29432bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f4210c6fcc505e0e2984540f29432bc)): ?>
<?php $component = $__componentOriginal8f4210c6fcc505e0e2984540f29432bc; ?>
<?php unset($__componentOriginal8f4210c6fcc505e0e2984540f29432bc); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>

                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::ViewUsers->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.users'),'active' => request()->routeIs('admin.users')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.users')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.users'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-users'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Manage Users')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::ViewSuppliers->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.suppliers'),'active' => request()->routeIs('admin.suppliers')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.suppliers')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.suppliers'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-identification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Manage Suppliers')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::ViewRoles->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.roles-and-permissions'),'active' => request()->routeIs('admin.roles-and-permissions')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.roles-and-permissions')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.roles-and-permissions'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-lock-closed'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Roles & Permissions')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
                <?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53)): ?>
<?php $attributes = $__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53; ?>
<?php unset($__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32f1c3cbb504341c40b1a5cc46044f53)): ?>
<?php $component = $__componentOriginal32f1c3cbb504341c40b1a5cc46044f53; ?>
<?php unset($__componentOriginal32f1c3cbb504341c40b1a5cc46044f53); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php if (\Illuminate\Support\Facades\Blade::check('cananyCM', [
            $permission::AccessActiveEvents->value,
            $permission::ViewDeliveries->value,
            $permission::ViewEventInventory->value,
            $permission::ViewRepairments->value,
            $permission::ViewWastes->value,
            $permission::ViewEvents->value
        ])): ?>
            <?php if (isset($component)) { $__componentOriginal32f1c3cbb504341c40b1a5cc46044f53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.index','data' => ['persisted' => true,'initiallyOpen' => true,'key' => ''.e(__('ui.pages.Event Managment')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['persisted' => true,'initiallyOpen' => true,'key' => ''.e(__('ui.pages.Event Managment')).'']); ?>
                 <?php $__env->slot('trigger', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginal8f4210c6fcc505e0e2984540f29432bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f4210c6fcc505e0e2984540f29432bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php echo e(__('ui.pages.Event Managment')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f4210c6fcc505e0e2984540f29432bc)): ?>
<?php $attributes = $__attributesOriginal8f4210c6fcc505e0e2984540f29432bc; ?>
<?php unset($__attributesOriginal8f4210c6fcc505e0e2984540f29432bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f4210c6fcc505e0e2984540f29432bc)): ?>
<?php $component = $__componentOriginal8f4210c6fcc505e0e2984540f29432bc; ?>
<?php unset($__componentOriginal8f4210c6fcc505e0e2984540f29432bc); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>
                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::AccessActiveEvents->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.events.actived'),'active' => request()->routeIs('admin.events.actived')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.events.actived')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.events.actived'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-bolt'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Active Events')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
                <?php endif; ?>

                

                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::ViewEventInventory->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.events.inventory'),'active' => request()->routeIs('admin.events.inventory')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.events.inventory')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.events.inventory'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-chart-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Event Inventory')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>

                    
                <?php endif; ?>

                

                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::ViewEvents->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.events.history'),'active' => request()->routeIs('admin.events.history')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.events.history')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.events.history'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-rectangle-stack'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Event History')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::ViewWastes->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.events.wastes'),'active' => request()->routeIs('admin.events.wastes')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.events.wastes')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.events.wastes'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-square-3-stack-3d'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Waste Managment')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
                <?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53)): ?>
<?php $attributes = $__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53; ?>
<?php unset($__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32f1c3cbb504341c40b1a5cc46044f53)): ?>
<?php $component = $__componentOriginal32f1c3cbb504341c40b1a5cc46044f53; ?>
<?php unset($__componentOriginal32f1c3cbb504341c40b1a5cc46044f53); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php if (\Illuminate\Support\Facades\Blade::check('cananyCM', [
            $permission::ViewReagents->value,
            $permission::ViewReagentsInventory->value,
        ])): ?>
            <?php if (isset($component)) { $__componentOriginal32f1c3cbb504341c40b1a5cc46044f53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.index','data' => ['persisted' => true,'initiallyOpen' => true,'key' => ''.e(__('ui.pages.Reagent Management')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['persisted' => true,'initiallyOpen' => true,'key' => ''.e(__('ui.pages.Reagent Management')).'']); ?>
                 <?php $__env->slot('trigger', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginal8f4210c6fcc505e0e2984540f29432bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f4210c6fcc505e0e2984540f29432bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php echo e(__('ui.pages.Reagent Management')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f4210c6fcc505e0e2984540f29432bc)): ?>
<?php $attributes = $__attributesOriginal8f4210c6fcc505e0e2984540f29432bc; ?>
<?php unset($__attributesOriginal8f4210c6fcc505e0e2984540f29432bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f4210c6fcc505e0e2984540f29432bc)): ?>
<?php $component = $__componentOriginal8f4210c6fcc505e0e2984540f29432bc; ?>
<?php unset($__componentOriginal8f4210c6fcc505e0e2984540f29432bc); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>
                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::ViewReagents->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.reagents.managment'),'active' => request()->routeIs('admin.reagents.managment')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.reagents.managment')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.reagents.managment'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-beaker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Manage Reagents')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('canCM', $permission::ViewReagentsInventory->value)): ?>
                    <?php if (isset($component)) { $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fl.dropdown.item','data' => ['href' => route('admin.reagents'),'active' => request()->routeIs('admin.reagents')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('fl.dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.reagents')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.reagents'))]); ?>
                         <?php $__env->slot('icon', null, []); ?> 
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-chart-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                         <?php $__env->endSlot(); ?>
                        <?php echo e(__('ui.pages.Reagent Inventory')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $attributes = $__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__attributesOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1)): ?>
<?php $component = $__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1; ?>
<?php unset($__componentOriginal5b6dc1f1e9031fb8ba6e5e5a10a157d1); ?>
<?php endif; ?>

                    
                <?php endif; ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53)): ?>
<?php $attributes = $__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53; ?>
<?php unset($__attributesOriginal32f1c3cbb504341c40b1a5cc46044f53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32f1c3cbb504341c40b1a5cc46044f53)): ?>
<?php $component = $__componentOriginal32f1c3cbb504341c40b1a5cc46044f53; ?>
<?php unset($__componentOriginal32f1c3cbb504341c40b1a5cc46044f53); ?>
<?php endif; ?>
        <?php endif; ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91c821ac63991f310c0b8692f4f16f0a)): ?>
<?php $attributes = $__attributesOriginal91c821ac63991f310c0b8692f4f16f0a; ?>
<?php unset($__attributesOriginal91c821ac63991f310c0b8692f4f16f0a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91c821ac63991f310c0b8692f4f16f0a)): ?>
<?php $component = $__componentOriginal91c821ac63991f310c0b8692f4f16f0a; ?>
<?php unset($__componentOriginal91c821ac63991f310c0b8692f4f16f0a); ?>
<?php endif; ?>

    <div class="flex-1 p-4 lg:p-8 lg:ml-80 mt-16">

        <?php echo e($slot); ?>


    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald4c772c02301431d3253f64117700596)): ?>
<?php $attributes = $__attributesOriginald4c772c02301431d3253f64117700596; ?>
<?php unset($__attributesOriginald4c772c02301431d3253f64117700596); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald4c772c02301431d3253f64117700596)): ?>
<?php $component = $__componentOriginald4c772c02301431d3253f64117700596; ?>
<?php unset($__componentOriginald4c772c02301431d3253f64117700596); ?>
<?php endif; ?>


<?php /**PATH C:\Users\azahe\OneDrive\Escritorio\unir\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>