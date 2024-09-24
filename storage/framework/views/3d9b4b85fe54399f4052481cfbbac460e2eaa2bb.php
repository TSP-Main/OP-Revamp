
<?php $__env->startSection('title', 'Page Not Found'); ?>
<?php $__env->startSection('content'); ?>

<!-- 404 area start -->
<div class="ltn__404-area ltn__404-area-1 mb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="error-404-inner text-center">
                    <div class="error-img mb-30">
                        <img src="/img/error-1.png" alt="#">
                    </div>
                    <h1 class="error-404-title d-none">404</h1>
                    <h2>Working, Soon to Appear!</h2>
                    <!-- <h3>Oops! Looks like something going rong</h3> -->
                    <p>Oops! The page you are looking for is currently being updated by our team. Please check back shortly.</p>
                    <div class="btn-wrapper">
                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-transparent"><i class="fas fa-long-arrow-alt-left"></i> BACK</a>
                        <a href="/" class="btn btn-transparent">HOME</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 404 area end -->


<?php $__env->stopSection(); ?>

<?php if (! $__env->hasRenderedOnce('5c6f85e8-8174-4422-be7b-e0df89414f1a')): $__env->markAsRenderedOnce('5c6f85e8-8174-4422-be7b-e0df89414f1a');
$__env->startPush('scripts'); ?>
<script>

</script>
<?php $__env->stopPush(); endif; ?>
<?php echo $__env->make('web.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OP-Phill\resources\views/web/pages/404.blade.php ENDPATH**/ ?>