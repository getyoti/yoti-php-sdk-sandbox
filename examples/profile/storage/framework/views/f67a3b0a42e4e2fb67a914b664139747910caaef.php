<?php if($value instanceof Yoti\Profile\Attribute\MultiValue): ?>
    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $multiValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partial/attribute', ['value' => $multiValue], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php elseif($value instanceof \Yoti\Media\Image): ?>
    <img src="<?php echo e($value->getBase64Content()); ?>" />
<?php elseif($value instanceof \Yoti\Profile\Attribute\DocumentDetails): ?>
    <?php echo $__env->make('partial/documentdetails', ['documentDetails' => $value], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php elseif($value instanceof \DateTime): ?> {
    <?php echo e($value->format('d-m-Y')); ?>

<?php else: ?>
    <?php echo e($value); ?>

<?php endif; ?><?php /**PATH /usr/share/nginx/html/resources/views/partial/attribute.blade.php ENDPATH**/ ?>