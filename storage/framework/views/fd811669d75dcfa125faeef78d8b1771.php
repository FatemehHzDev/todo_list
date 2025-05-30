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


         <h1><?php echo e(__('لیست کارها')); ?></h1>

        <button type="submit" wire:click="amalkard"><?php echo e(__('عملکرد من')); ?></button>
        <span style="color:blue"><?php echo e($total_task); ?></span>
        <span style="color:green"><?php echo e($bishtarin_task); ?></span>
        <span style="color: red"><?php echo e($kamtarin_task); ?></span>

        <table>
            <tr>
                <th><?php echo e(__('عنوان کار')); ?></th>
                <th><?php echo e(__('شرح')); ?></th>
                <th><?php echo e(__('تایید مدیر')); ?></th>
                <th><?php echo e(__('تاریخ مقرر')); ?></th>
                <th><?php echo e(__('تاریخ انجام')); ?></th>
                <th><?php echo e(__(' ثبت تاریخ_ویرایش تاریخ ')); ?></th>
                <th><?php echo e(__('زمان باقی مانده')); ?></th>
            </tr>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = \App\Models\Task::where('user_id', Auth::id())->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($task->title); ?></td>
                    <td><?php echo e($task->description); ?></td>
                    <td style="background-color:<?php if($task['approved']==1): ?><?php echo e(__('lightgreen')); ?><?php endif; ?>;font-size: 15px;
                    color:<?php if($task['approved']==0): ?><?php echo e(__('red')); ?><?php endif; ?>">


                        <!--[if BLOCK]><![endif]--><?php if($task['approved']==1): ?>
                            <?php echo e(__('تایید شد.')); ?>

                        <?php else: ?>
                            <?php echo e(__('تایید نشد.')); ?>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="background-color:<?php $__currentLoopData = $task->taskDos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskDo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                        <?php if(test_date($task['deadline'],$taskDo->date_do)): ?>
                            <?php echo e(__('lightgreen')); ?>

                        <?php else: ?>
                            <?php echo e(__('orange')); ?>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>"><?php echo e($task->deadline); ?> </td>

                    <td style="background-color:<?php $__currentLoopData = $task->taskDos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskDo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if(test_date($task['deadline'],$taskDo->date_do)): ?>
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
                            <span>تاریخ انجام ثبت نشده</span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td>

                        <!--[if BLOCK]><![endif]--><?php if($selectedTaskId != $task->id ): ?>

                            <button style="display: <?php if( $taskDo && $editingTaskid==$taskDo->id && $taskDo->task_id==$task->id ): ?><?php echo e(__('none')); ?><?php endif; ?>"
                                    type="submit" wire:click="start(<?php echo e($task->id); ?>)"

                            >++
                            </button>

                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $task->taskDos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskDo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <!--[if BLOCK]><![endif]--><?php if($taskDo && $editingTaskid!=$taskDo->id): ?>
                                    <button type="submit" wire:click="start_edit(<?php echo e($taskDo->id); ?>)">ویرایش</button>

                                <?php else: ?>
                                    <form wire:submit="update_date">

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

                                        <input type="submit" value="ویرایش">
                                    </form>
                                    <button type="submit" wire:click="cancel_update"><?php echo e(__('لغو')); ?></button>
                                    <span style="color: red"><?php echo e($payam); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                    <?php else: ?>
                        <form wire:submit="store">
                            <select wire:model.live="year" >
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

                            <select wire:model.live="day"  >
                                <option disabled value="" ><?php echo e(__('روز')); ?></option>
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
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['task_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <?php echo e($message); ?>

                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            <input type="submit" value="ذخیره">
                        </form>
                        <button type="submit" wire:click="cancel"><?php echo e(__('لغو')); ?></button>
                        <span style="color: red"><?php echo e($payam); ?></span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                    <td>
                        <button type="button" class="btn btn-light" wire:click="zaman(<?php echo e($task); ?>)">
                            <?php echo e(__('روز های باقی مانده')); ?></button>

                        <span style="color:<?php if($day_mandeh>0): ?>
                                <?php echo e(__('red')); ?>

                           <?php else: ?>
                            <?php echo e(__('green')); ?>

                             <?php endif; ?>">


                        <?php if($test_id==$task['id'] && $day_mandeh<0): ?>
                                <?php echo e(-$day_mandeh); ?>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if($test_id==$task['id'] && $day_mandeh>0): ?>
                                <?php echo e($day_mandeh); ?>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </table>

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div><?php /**PATH D:\xampp\htdocs\todo_list\resources\views\livewire/task_do.blade.php ENDPATH**/ ?>