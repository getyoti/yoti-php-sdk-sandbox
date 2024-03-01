<!DOCTYPE html>
<html class="yoti-html">

<head>
    <meta charset="utf-8">
    <title>Yoti client example</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/profile.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet" />
</head>

<body class="yoti-body">
    <main class="yoti-profile-layout">
        <section class="yoti-profile-user-section">

            <div class="yoti-profile-picture-powered-section">
                <span class="yoti-profile-picture-powered">Powered by</span>
                <a href="https://www.yoti.com" target="_blank">
                    <img class="yoti-logo-image" src="/assets/images/logo.png" srcset="/assets/images/logo@2x.png 2x" alt="Yoti" />
                </a>
            </div>

            <div class="yoti-profile-picture-section">
                <?php if($selfie): ?>
                <div class="yoti-profile-picture-area">
                    <img src="<?php echo e($selfie->getValue()->getBase64Content()); ?>" class="yoti-profile-picture-image" alt="Yoti" />
                    <i class="yoti-profile-picture-verified-icon"></i>
                </div>
                <?php endif; ?>

                <?php if($fullName): ?>
                <div class="yoti-profile-name">
                    <?php echo e($fullName->getValue()); ?>

                </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="yoti-attributes-section">
            <a href="/">
                <img class="yoti-company-logo" src="/assets/images/company-logo.jpg" alt="company logo">
            </a>

            <div class="yoti-attribute-list-header">
                <div class="yoti-attribute-list-header-attribute">Attribute</div>
                <div class="yoti-attribute-list-header-value">Value</div>
                <div>Anchors</div>
            </div>

            <div class="yoti-attribute-list-subheader">
                <div class="yoti-attribute-list-subhead-layout">
                    <div>S / V</div>
                    <div>Value</div>
                    <div>Sub type</div>
                </div>
            </div>

            <div class="yoti-attribute-list">
                <?php $__currentLoopData = $profileAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item['obj']): ?>
                    <div class="yoti-attribute-list-item">
                        <div class="yoti-attribute-name">
                            <div class="yoti-attribute-name-cell">
                                <i class="<?php echo e($item['icon']); ?>"></i>
                                <span class="yoti-attribute-name-cell-text"><?php echo e($item['name']); ?></span>
                            </div>
                        </div>
                        <div class="yoti-attribute-value">
                            <div class="yoti-attribute-value-text">
                            <?php switch($item['name']):
                                case ('Age Verification'): ?>
                                    <?php echo $__env->make('partial/ageverification', ['ageVerification' => $item['age_verification']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php break; ?>
                                <?php case ('Structured Postal Address'): ?>
                                    <?php echo $__env->make('partial/address', ['address' => $item['obj']->getValue()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php break; ?>
                                <?php case ('Identity Profile Report'): ?>
                                    <?php echo $__env->make('partial/report', ['report' => $item['obj']->getValue()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php break; ?>
                                <?php default: ?>
                                    <?php echo $__env->make('partial/attribute', ['value' => $item['obj']->getValue()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endswitch; ?>
                            </div>
                        </div>
                        <div class="yoti-attribute-anchors-layout">
                            <div class="yoti-attribute-anchors-head -s-v">S / V</div>
                            <div class="yoti-attribute-anchors-head -value">Value</div>
                            <div class="yoti-attribute-anchors-head -subtype">Sub type</div>

                            <?php $__currentLoopData = $item['obj']->getAnchors(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anchor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="yoti-attribute-anchors -s-v"><?php echo e($anchor->getType()); ?></div>
                                <div class="yoti-attribute-anchors -value"><?php echo e($anchor->getValue()); ?></div>
                                <div class="yoti-attribute-anchors -subtype"><?php echo e($anchor->getSubType()); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    </main>
</body>

</html><?php /**PATH /usr/share/nginx/html/resources/views/profile.blade.php ENDPATH**/ ?>