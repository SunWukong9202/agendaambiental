<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'key' => 'default',
    'initiallyOpen' => false,
    'persisted' => false,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'key' => 'default',
    'initiallyOpen' => false,
    'persisted' => false,
]); ?>
<?php foreach (array_filter(([
    'key' => 'default',
    'initiallyOpen' => false,
    'persisted' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    x-cloak
    x-modelable="expanded"
    class="fi-sidebar-group flex flex-col gap-y-1"
    <?php echo e($attributes->whereDoesntStartWith('class')); ?>

    <?php if($persisted): ?>
        x-data="{ expanded: $persist(<?php echo \Illuminate\Support\Js::from($initiallyOpen)->toHtml() ?>).as('<?php echo e($key); ?>').using(sessionStorage) }"
    <?php else: ?>
        x-data="{ expanded: <?php echo \Illuminate\Support\Js::from(!isset($trigger))->toHtml() ?> }"
    <?php endif; ?>
> 
    <?php if(isset($trigger)): ?>
        <span
            class="cursor-pointer relative"
            @click="expanded = !expanded">
            <?php echo e($trigger); ?>

        </span>
    <?php endif; ?>
        
    <ul
        x-show="expanded"
        x-transition
        x-collapse.duration.350ms
        class="flex flex-col gap-y-1"
    >
        <?php echo e($slot); ?>

    </ul>
</div>
<?php /**PATH C:\Users\azahe\OneDrive\Escritorio\unir\resources\views/components/fl/dropdown/index.blade.php ENDPATH**/ ?>