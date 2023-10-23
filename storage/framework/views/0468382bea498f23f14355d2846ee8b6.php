<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('物件写真編集')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">
        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div>
            <img src="<?php echo e(asset('storage/'. $image->image_path)); ?>" width="400" height="400">
            <br>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2>

                <form action="<?php echo e(route('image.check')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($image->agent_check === 1): ?>
                    <input type="checkbox" checked="checked" name="check" id="check" value="0">チェック
                    <?php else: ?>
                    <input type="checkbox" name="check" id="check" value="1">チェック
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <br><br>
                    <button type="submit">完了</button>

                </form>

                </h2>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            <?php echo e(__('物件写真登録・更新')); ?>

                        </h2>
                    </header>

                    <form method="POST" action="<?php echo e(route('image.update')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('patch'); ?> <!-- これがないと画像が表示されない -->

                        <br>
                        <p>物件写真1を登録・更新</p>
                        <input type="file" name="image1">
                        <br><br>
                        <p>物件写真2を登録・更新</p>
                        <input type="file" name="image2">
                        <br><br>
                        <p>物件写真3を登録・更新</p>
                        <input type="file" name="image3">
                        <br><br>
                        <button type="submit">登録・更新</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Applications/MAMP/htdocs/fudosanapp/resources/views/image/edit.blade.php ENDPATH**/ ?>