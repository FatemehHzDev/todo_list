<?php

use App\Models\Task;
use App\Models\Task_do;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div>
    <style>
        table {
            margin: 50px auto;

        }

        tr {
            width: 30px;
        }

        th {

            background-color: lightblue;
            color: black;
        }

        th, td {
            border-bottom: 1px solid darkblue;
            text-align: center;
            padding: 10px;
        }
    </style>

    <!-- Authentication Links -->
    <!--[if BLOCK]><![endif]--><?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('login')); ?>">Login</a>
        <a href="<?php echo e(route('register')); ?>">Register</a>
    <?php else: ?>


        <h4 style="color: red">
            <!--[if BLOCK]><![endif]--><?php if(Auth()->user()->hasrole('admin')): ?>
                <span ><?php echo e(__("ادمین")); ?></span>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <?php echo e(Auth::user()->name); ?>___
            <span style="color: black">
                 <?php echo e(Auth::user()->mobile); ?>

                </span>
                <span  class="myspan"><?php echo e(__("داشبورد")); ?></span>
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                <?php echo csrf_field(); ?>
                <input type="submit" value="خروج">
            </form>

        </h4>
           <a href="<?php echo e(route('task_do')); ?>"><?php echo e(__("کارهای من")); ?></a>
        <!--[if BLOCK]><![endif]--><?php if(Auth()->user()->hasrole('admin')): ?>

        <a href="<?php echo e(route('tasks')); ?>"><?php echo e(__("افزودن کارها")); ?></a>


        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div><?php /**PATH D:\xampp\htdocs\todo_list\resources\views\livewire/dashboard.blade.php ENDPATH**/ ?>