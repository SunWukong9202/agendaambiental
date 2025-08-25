<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'text'
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'text'
]); ?>
<?php foreach (array_filter(([
    'text'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<a
<?php echo e($attributes->class([
    'cursor-pointer text-gray-900 bg-white focus:outline-none hover:bg-gray-200 focus:ring-gray-100 rounded-2xl px-5 py-1 me-2  dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 flex-shrink-0'
])); ?>


>
    <?php if($slot->isEmpty()): ?>
        <?php echo e($text); ?>

    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
</a><?php /**PATH C:\Users\azahe\OneDrive\Escritorio\unir\resources\views/components/link/pill.blade.php ENDPATH**/ ?>