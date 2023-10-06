<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <?php echo e(__('画像登録create')); ?>

        </h2>

        <p class="mt-1 text-sm text-gray-600">
            <?php echo e(__("画像を登録できます")); ?>

        </p>
    </header>

    <form method="POST" action="<?php echo e(route('image.create')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <p>画像1</p>
        <input type="file" name="image1">
        <p>画像2</p>
        <input type="file" name="image2">
        <p>画像3</p>
        <input type="file" name="image3">
        <button type="submit">登録</button>
    </form>
</section>
<?php /**PATH /Applications/MAMP/htdocs/fudosanapp/resources/views/image/partials/create.blade.php ENDPATH**/ ?>