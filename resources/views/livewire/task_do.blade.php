<?php

use App\Models\Task;
use App\Models\Task_do;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

function getUser()
{
}new #[Layout('layouts.base')] class extends Component {
    public $taskDos;
    public $taskDo;
    public $task_id;
    public $year;
    public $month='';
    public $day ='';
    public $st;
    public $approved;
    public $update_approved = '';
    public $selectedTaskId = null; // برای ذخیره‌سازی task_id انتخاب‌شده
    public $act = "";
    public $test = "";
    public $edit_date = null;
    public $payam = '';
    public $total_task;
    public $bishtarin_task;
    public $kamtarin_task;
    public $yy;
    public $mm;
    public $dd;
    public $today;
    public $y_t;
    public $m_t;
    public $d_t;
    public $now_timestam;
    public $task_timestam;
    public $day_mandeh;
    public $test_id;
    public $zaman_mandeh;
    public $editingTaskid;
    public  $yyb;
    public $jc;
    public int $ld = 31;

//    public function login(Request $req)
//    {
//        $mobile = $req->input('mobile');
//        $password = $req->input('password');
//
//        $check= DB::table('users')->where(['mobile' => $mobile, 'password' => $password])->get();
//
//        if (count($check ) > 0) {
//            return "page";
//
//        } else {
//            // echo "Login Failed!";
//            return Redirect::route('login')->with(['error' => "Invalid mobile or Password!!"]);
//        }
//    }

    public function mount()
    {
        $this->get_task();


    }

    public function get_task()
    {
        $this->month = jdate('m', '', '', '', 'en');
        $this->day = jdate('d', '', '', '', 'en');
        $this->yyb = jdate('Y', '', '', '', 'en');
        $this->task_id = \App\Models\Task::where('user_id', Auth::id())->orderby('id', 'desc')->get();
        $this->taskDos = \App\Models\Task_do::where('user_id', Auth::id())->get();
        $this->year = jdate('Y', '', '', '', 'en');
        $this->set();
    }

    public function store()
    {
        $this->validate([
         'task_id'=>['unique:'. Task_do::class],
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',

        ]);
        $t_d = new Task_do();
        $t_d['task_id'] = $this->task_id;
        $t_d['user_id'] = Auth::id();
        $t_d['year'] = $this->year;
        $t_d['month'] = $this->month;
        $t_d['day'] = $this->day;
        $t_d['date_do'] = $this->year . '-' . $this->month . '-' . $this->day;
        if (jcheckdate($this->month, $this->day, $this->year) == true) {
            $t_d->save();
            $this->get_task();
            $this->test = $t_d['date_do'];
            $this->resetValidation();
            $this->resetExcept('year', 'selectedTaskId ','ld','yyb','month','day');
        } else {
            $this->payam = "تاریخ وارد شده نامعتبر است.";

        }

    }

    public function start($taskId)
    {
        $this->selectedTaskId = $taskId; // ذخیره‌سازی task_id انتخاب‌شده
        $this->st = Task::find($taskId);
        $this->task_id = $this->st->id;
        $this->open = '';

    }

    public function cancel()
    {
        $this->reset('selectedTaskId');
        $this->get_task();
        $this->reset('payam');
    }

//
    public function update_approved(Task_do $taskDo)
    {

        $this->update_approved = $taskDo;

        if ($taskDo['approved'] == 'false') {
            $this->update_approved['approved'] = 'true';
        } else {
            $this->update_approved['approved'] = 'false';
        }
        $this->update_approved->save();
        $this->get_task();
        $this->reset('update_approved');

    }

    public function start_edit(Task_do $taskDo)
    {
      $this-> editingTaskid=$taskDo['id'];
        $this->act = 'edit';
        $this->edit_date = $taskDo;
        $this->year = $taskDo['year'];
        $this->month = $taskDo['month'];
        $this->day = $taskDo['day'];
    }

    public function update_date()
    {
        $this->validate([
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
        ]);

        $this->edit_date['date_do'] = $this->year . '-' . $this->month . '-' . $this->day;
        $this->edit_date['year'] = $this->year;
        $this->edit_date['month'] = $this->month;
        $this->edit_date['day'] = $this->day;
        if (jcheckdate($this->month, $this->day, $this->year) == true) {
            $this->edit_date->save();
            $this->reset('act');

            $this->resetValidation();
            $this->get_task();
            $this->resetExcept('year', 'selectedTaskId','ld','yyb');
        } else {
            $this->payam = "تاریخ وارد شده نامعتبر است.";
        }
    }
    public function set(): void
    {
        if ($this->month > 6 and $this->month <= 12) {
            $this->ld = 30;
        } else {
            $this->ld = 31;
        }

    }


    public function cancel_update()
    {
        $this->reset('act');
        $this->get_task();

        $this->reset('editingTaskid');
        $this->reset('payam');


    }
    public function amalkard(){

        $this->bishtarin_task ="کارهای تایید شده" .Task::where('user_id', Auth::id())->where( 'approved',1)->count();
        $this->kamtarin_task = "کارهای تایید نشده".Task::where('user_id', Auth::id())->where( 'approved',0)->count();
        $this->total_task = "همه کارها".Task::where('user_id', Auth::id())->count();


    }
    public function zaman(Task $task)
    {
        $this->today = jdate('Y-m-d');
        $this->yy = substr($this->today, 0, 8);
        $this->mm = substr($this->today, 9, 4);
        $this->dd = substr($this->today, 14, 4);
        $this->now_timestam = jmktime('0', '0', '0', $this->mm, $this->dd, $this->yy);
        $this->y_t = $task['year'];
        $this->m_t = $task['month'];
        $this->d_t = $task['day'];
        $this->test_id = $task['id'];
        $this->task_timestam = jmktime('0', '0', '0', $this->m_t, $this->d_t, $this->y_t);
        $this->zaman_mandeh = $this->now_timestam - $this->task_timestam;
        if ($this->zaman_mandeh < 0) {
            $this->day_mandeh = $this->zaman_mandeh /86400;
        } else {
            $this->day_mandeh = 'زمان مقرر به پایان رسیده است';
        }
    }

}; ?>

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
    @guest
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    @else


         <h1>{{__('لیست کارها')}}</h1>

        <button type="submit" wire:click="amalkard">{{__('عملکرد من')}}</button>
        <span style="color:blue">{{$total_task}}</span>
        <span style="color:green">{{$bishtarin_task}}</span>
        <span style="color: red">{{$kamtarin_task}}</span>

        <table>
            <tr>
                <th>{{__('عنوان کار')}}</th>
                <th>{{__('شرح')}}</th>
                <th>{{__('تایید مدیر')}}</th>
                <th>{{__('تاریخ مقرر')}}</th>
                <th>{{__('تاریخ انجام')}}</th>
                <th>{{__(' ثبت تاریخ_ویرایش تاریخ ')}}</th>
                <th>{{__('زمان باقی مانده')}}</th>
            </tr>
            @foreach (\App\Models\Task::where('user_id', Auth::id())->get() as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td style="background-color:@if($task['approved']==1){{__('lightgreen')}}@endif;font-size: 15px;
                    color:@if($task['approved']==0){{__('red')}}@endif">


                        @if($task['approved']==1)
                            {{__('تایید شد.')}}
                        @else
                            {{__('تایید نشد.')}}
                        @endif
                    </td>
                    <td style="background-color:@foreach($task->taskDos as $taskDo)


                        @if(test_date($task['deadline'],$taskDo->date_do))
                            {{__('lightgreen')}}
                        @else
                            {{__('orange')}}
                        @endif
                    @endforeach">{{ $task->deadline }} </td>

                    <td style="background-color:@foreach($task->taskDos as $taskDo)
                     @if(test_date($task['deadline'],$taskDo->date_do))
                            {{__('lightgreen')}}
                        @else
                            {{__('orange')}}
                            @endif
                     @endforeach">
                        @if($task->taskDos && count($task->taskDos) > 0)
                        @foreach($task->taskDos as $taskDo)
                            {{ $taskDo->date_do }}
                        @endforeach
                        @else
                            <span>تاریخ انجام ثبت نشده</span>
                        @endif
                    </td>
                    <td>

                        @if($selectedTaskId != $task->id )

                            <button style="display: @if( $taskDo && $editingTaskid==$taskDo->id && $taskDo->task_id==$task->id ){{__('none')}}@endif"
                                    type="submit" wire:click="start({{ $task->id }})"

                            >++
                            </button>

                            @foreach($task->taskDos as $taskDo)
                                @if($taskDo && $editingTaskid!=$taskDo->id)
                                    <button type="submit" wire:click="start_edit({{ $taskDo->id}})">ویرایش</button>

                                @else
                                    <form wire:submit="update_date">

                                        <select wire:model.live="day">
                                            <option disabled value="" class="text-right">{{__('روز')}}</option>
                                            @for($d=1; $d<=$ld; $d++)
                                                @if($d<10)
                                                    @php($d = '0'.$d)
                                                @endif
                                                <option value="{{$d}}">{{$d}}</option>
                                            @endfor
                                        </select>
                                        @error('day')
                                        {{$message}}
                                        @enderror
                                        <select wire:model.live="month" wire:change="set" >
                                            <option disabled value="" >{{__('ماه')}}</option>
                                            @for($m=1; $m<=12; $m++)
                                                @if($m<10)
                                                    @php($m = '0'.$m)
                                                @endif
                                                <option value="{{$m}}">{{$m}}</option>
                                            @endfor
                                        </select>
                                        @error('month')
                                        {{$message}}
                                        @enderror
                                        <select wire:model.live="year"  >
                                            <option disabled value="" >{{__('سال')}}</option>
                                            @for($y=$yyb; $y<=$yyb+10; $y++)
                                                <option value="{{$y}}">{{$y}}</option>
                                            @endfor
                                        </select>
                                        @error('year')
                                        {{$message}}
                                        @enderror

                                        <input type="submit" value="ویرایش">
                                    </form>
                                    <button type="submit" wire:click="cancel_update">{{__('لغو')}}</button>
                                    <span style="color: red">{{$payam}}</span>
                                @endif
                    </td>
                    @endforeach

                    @else
                        <form wire:submit="store">
                            <select wire:model.live="year" >
                                <option disabled value="" >{{__('سال')}}</option>
                                @for($y=$yyb; $y<=$yyb+10; $y++)
                                    <option value="{{$y}}">{{$y}}</option>
                                @endfor
                            </select>
                            @error('year')
                            {{$message}}
                            @enderror

                            <select wire:model.live="month" wire:change="set" >
                                <option disabled value="" >{{__('ماه')}}</option>
                                @for($m=1; $m<=12; $m++)
                                    @if($m<10)
                                        @php($m = '0'.$m)
                                    @endif
                                    <option value="{{$m}}">{{$m}}</option>
                                @endfor
                            </select>
                            @error('month')
                            {{$message}}
                            @enderror

                            <select wire:model.live="day"  >
                                <option disabled value="" >{{__('روز')}}</option>
                                @for($d=1; $d<=$ld; $d++)
                                    @if($d<10)
                                        @php($d = '0'.$d)
                                    @endif
                                    <option value="{{$d}}">{{$d}}</option>
                                @endfor
                            </select>
                            @error('day')
                            {{$message}}
                            @enderror
                            @error('task_id')
                            {{$message}}
                            @enderror
                            <input type="submit" value="ذخیره">
                        </form>
                        <button type="submit" wire:click="cancel">{{__('لغو')}}</button>
                        <span style="color: red">{{$payam}}</span>
                    @endif


                    <td>
                        <button type="button" class="btn btn-light" wire:click="zaman({{$task}})">
                            {{__('روز های باقی مانده')}}</button>

                        <span style="color:@if($day_mandeh>0)
                                {{__('red')}}
                           @else
                            {{__('green')}}
                             @endif">


                        @if($test_id==$task['id'] && $day_mandeh<0)
                                {{-$day_mandeh}}
                            @endif
                            @if($test_id==$task['id'] && $day_mandeh>0)
                                {{$day_mandeh}}
                            @endif
                    </span>
                    </td>
                </tr>
            @endforeach
        </table>

    @endguest

</div>

