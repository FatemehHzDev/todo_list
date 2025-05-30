<?php if (isset($component)) { $__componentOriginal7442783a15dff2b0d32f2947a462c2e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7442783a15dff2b0d32f2947a462c2e2 = $attributes; } ?>
<?php $component = App\View\Components\BaseLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\BaseLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div>




       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit articles')): ?>
           You can EDIT ARTICLES.
           <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('publish articles')): ?>
            You can PUBLISH ARTICLES.
           <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete articles')): ?>
        You can delete ARTICLES.
    <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('only super-admins can see this section')): ?>
            Congratulations, you are a super-admin!
             <?php endif; ?>

    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary d-block col-1 mx-auto my-1 btn-md "><?php echo e(__('ورود')); ?></a>
    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary d-block col-1 mx-auto my-1 btn-md "><?php echo e(__('ثبت نام')); ?></a>


</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7442783a15dff2b0d32f2947a462c2e2)): ?>
<?php $attributes = $__attributesOriginal7442783a15dff2b0d32f2947a462c2e2; ?>
<?php unset($__attributesOriginal7442783a15dff2b0d32f2947a462c2e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7442783a15dff2b0d32f2947a462c2e2)): ?>
<?php $component = $__componentOriginal7442783a15dff2b0d32f2947a462c2e2; ?>
<?php unset($__componentOriginal7442783a15dff2b0d32f2947a462c2e2); ?>
<?php endif; ?>
<?php /**PATH D:\xampp\htdocs\todo_list\resources\views/welcome.blade.php ENDPATH**/ ?>