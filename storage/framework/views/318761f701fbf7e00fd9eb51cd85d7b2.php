<nav 
x-data="{count: 0}"
<?php echo e($attributes->class([
  'w-full bg-white shadow-sm dark:bg-gray-900 dark:ring-white/10 h-16 lg:h-20'
])); ?>

>
  <div class="px-4 sm:px-8 py-3">
      <div class="flex items-center justify-start rtl:justify-end">
        <button 
        x-on:click="$dispatch('open-sidebar', 'sidebar-btn')"  
        type="button" class="inline-flex items-center p-2 text-sm text-gray-500 dark:text-gray-900 rounded-lg lg:hidden hover:bg-gray-100">
            <span class="sr-only">Open sidebar</span>
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-m-bars-3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-6']); ?>
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
        </button>
    
        <?php echo e($slot); ?>

    </div>
</nav>


<?php /**PATH C:\Users\azahe\OneDrive\Escritorio\unir\resources\views/components/navbar.blade.php ENDPATH**/ ?>