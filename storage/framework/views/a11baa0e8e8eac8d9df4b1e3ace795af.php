<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <?php echo e(__('プロフィール詳細')); ?>

        </h2>

        <p class="mt-1 text-sm text-gray-600">
            <?php echo e(__("アカウントのプロフィール情報を更新できます")); ?>

        </p>
    </header>

    <form method="POST" action="<?php echo e(route('image.update')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>
        <input type="file" name="image">
        <button type="submit">登録する</button>
    </form>



</section>
<?php /**PATH /Applications/MAMP/htdocs/laravel/resources/views/image/partials/image.blade.php ENDPATH**/ ?>