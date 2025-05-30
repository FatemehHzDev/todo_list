<?php

use App\Models\Task;
use App\Models\Task_do;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div>
    <style>
        table {
            margin: 50px auto;

        }

        th, td {
            border-bottom: 1px solid blueviolet;

            text-align: center;
            padding: 5px;
        }
    </style>

<div class="observe">

        <select  wire:model="task_user">
            <option disabled value="">انتخاب کاربر...</option>

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = \App\Models\User::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        </select>
        <button type="button" class="btn btn-outline-dark" wire:click="amalkard()"><?php echo e(__('عملکرد کاربر')); ?></button>

        <div>

            <span style="color:blue"><?php echo e($total_task); ?></span>
            <span style="color:green"><?php echo e($bishtarin_task); ?></span>
            <span style="color: red"><?php echo e($kamtarin_task); ?></span>

        </div>
    </div>
    
    <span style="" class="myspan">  <?php echo e(jdate('Y-m-d')); ?></span><br>

    
    <div class="myform">
        <input type="text" wire:model="title" placeholder="عنوان">
        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php echo e($message); ?>

        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        <input type="text" wire:model="description" placeholder="شرح">
        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php echo e($message); ?>

        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        <select wire:model="user_id">
            <option  value="">انتخاب کاربر...</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = \App\Models\User::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php echo e($message); ?>

        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        <select wire:model.live="day">
            <option disabled value="" class="text-right"><?php echo e(__('روز')); ?></option>
            <!--[if BLOCK]><![endif]--><?php for($d=1; $d<=$ld; $d++): ?>
                <!--[if BLOCK]><![endif]--><?php if($d<10): ?>
                    <?php ($d = '0'.$d); ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <option value="<?php echo e($d); ?>"><?php echo e($d); ?></option>
            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
        </select>
        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php echo e($message); ?>

        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

        <select wire:model.live="month" wire:change="set" >
            <option disabled value="" ><?php echo e(__('ماه')); ?></option>
            <!--[if BLOCK]><![endif]--><?php for($m=1; $m<=12; $m++): ?>
                <!--[if BLOCK]><![endif]--><?php if($m<10): ?>
                    <?php ($m = '0'.$m); ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <option value="<?php echo e($m); ?>"><?php echo e($m); ?></option>
            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
        </select>
        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php echo e($message); ?>

        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

        <select wire:model.live="year"  >
            <option disabled value="" ><?php echo e(__('سال')); ?></option>
            <!--[if BLOCK]><![endif]--><?php for($y=$yyb; $y<=$yyb+10; $y++): ?>
                <option value="<?php echo e($y); ?>"><?php echo e($y); ?></option>
            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
        </select>
        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php echo e($message); ?>

        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        <select wire:model="status">
            <option  value="">انتخاب اولویت...</option>
            <option value="1"><?php echo e(__('بیشتر')); ?></option>
            <option value="2"><?php echo e(__('کمتر')); ?></option>
        </select>
        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php echo e($message); ?>

        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if($act=='create'): ?>
            <button type="button" class="btn btn-outline-success" wire:click="store"><?php echo e(__('ثبت')); ?></button>

        <?php else: ?>
            <button type="button" class="btn btn-outline-success" wire:click="update_task"><?php echo e(__('ویرایش')); ?></button>
            <button type="button" class="btn btn-outline-danger" wire:click="cancel_update"><?php echo e(__('لغو')); ?></button>

        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <span style="color: red"><?php echo e($payam); ?></span>

    </div>


    


    <div class="search">
        <input type="text" wire:model="filter" placeholder="جستجو">
        <button type="button" class="btn btn-success" wire:click="fil">جستجو</button>
        
    </div>


    <table class="mytable">

        <tr>
            <th><?php echo e(__('شناسه')); ?></th>
            <th><?php echo e(__('شناسه_نام کاربر')); ?></th>
            <th><?php echo e(__('عنوان')); ?></th>
            <th><?php echo e(__('شرح')); ?></th>
            <th><?php echo e(__('موعد مقرر')); ?></th>
            <th><?php echo e(__('تاریخ انجام')); ?></th>
            <th><?php echo e(__('اولویت')); ?></th>
            <th><?php echo e(__('تایید مدیر')); ?></th>
            <th><?php echo e(__('.....')); ?></th>
        </tr>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($task->id); ?></td>
                <td>
                    <?php echo e($task->user_id); ?>

                    <?php echo e(__('_')); ?>

                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = \App\Models\User::where('id', $task->user_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($user->name); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </td>
                <td><?php echo e($task->title); ?></td>
                <td><?php echo e($task->description); ?></td>
                <td style="background-color:<?php $__currentLoopData = \App\Models\Task_do::where('task_id', $task->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_do): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(test_date($task->deadline, $task_do->date_do)): ?>
                            <?php echo e(__('lightgreen')); ?>

                        <?php else: ?>
                            <?php echo e(__('orange')); ?>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>"
                ><?php echo e($task->deadline); ?>

                </td>
                <td style="background-color:<?php $__currentLoopData = \App\Models\Task_do::where('task_id', $task->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_do): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(test_date($task->deadline, $task_do->date_do)): ?>
                            <?php echo e(__('lightgreen')); ?>

                        <?php else: ?>
                            <?php echo e(__('orange')); ?>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">








                    <!--[if BLOCK]><![endif]--><?php if($task->taskDos && count($task->taskDos) > 0): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $task->taskDos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskDo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($taskDo->date_do); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                        تاریخ انجام ثبت نشده
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </td>
                <td>
                    <!--[if BLOCK]><![endif]--><?php if($task->status == '1'): ?>
                        <?php echo e(__('بیشتر')); ?>

                    <?php else: ?>
                        <?php echo e(__('کمتر')); ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </td>
                <td style="background-color:<?php if($task->approved == 1): ?><?php echo e(__('lightgreen')); ?><?php endif; ?>
                ;font-size: 15px;color:<?php if($task->approved == 0): ?><?php echo e(__('red')); ?><?php endif; ?>">
                    <!--[if BLOCK]><![endif]--><?php if($task->approved == 1): ?>
                        <?php echo e(__('تایید شد.')); ?>

                    <?php else: ?>
                        <?php echo e(__('تایید نشد.')); ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </td>
                <td>
                    <input type="checkbox" name="<?php echo e($task->id); ?>"
                           <?php if($task->approved == 1): ?>
                               checked
                           <?php endif; ?>
                           wire:click="edit(<?php echo e($task->id); ?>)" >

                    <button type="button" class="btn btn-light"
                            wire:click="edit_taskk(<?php echo e($task); ?>)"><?php echo e(__('ویرایش')); ?></button>
                    <button type="button" class="btn btn-light"
                            wire:click="zaman(<?php echo e($task); ?>)"><?php echo e(__('روز های باقی مانده')); ?></button>
                    <span style="color:<?php if($day_mandeh>0): ?>
                                <?php echo e(__('red')); ?>

                           <?php else: ?>
                            <?php echo e(__('green')); ?>

                             <?php endif; ?>">
                        <?php if($test_id == $task->id && $day_mandeh<0): ?>
                            <?php echo e(-$day_mandeh); ?>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($test_id == $task->id && $day_mandeh>0): ?>
                            <?php echo e($day_mandeh); ?>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </span>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </table>
</div><?php /**PATH D:\xampp\htdocs\todo_list\resources\views\livewire/task/list.blade.php ENDPATH**/ ?>