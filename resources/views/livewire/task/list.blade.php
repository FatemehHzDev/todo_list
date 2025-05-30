<?php

use App\Models\Task;
use App\Models\Task_do;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.base')] class extends Component {
    public $tasks = '';
    public $users = '';
    public $user_id = '';
    public $description = '';
    public $title = '';
    public $year;
    public $e_year = '';
    public  $yyb;
    public $jc;
    public int $ld = 31;
    public $month = '';
    public $day = '';

    public $edit_task = '';
    public $task_dos;
    public $status = '';
    public ?Task $editing = null;
    public $act = 'create';
    public $total_task = '';
    public $bishtarin_task = '';
    public $kamtarin_task = '';
    public $today;
    public $y;
    public $m;
    public $d;
    public $yy;
    public $mm;
    public $dd;
    public $zaman_mandeh;
    public $z_y;
    public $z_m;
    public $z_d;
    public $now_timestam;
    public $task_timestam;
    public $day_mandeh;
    public $y_t;
    public $m_t;
    public $d_t;
    public $filter = '';
    public $test_id;
    public $test_year;
    public $task_user;
    public $payam = "";

    public function get_task()

    {
        $this->loadusers();
        $this->task_user = '';
        $this->month = jdate('m', '', '', '', 'en');
        $this->day = jdate('d', '', '', '', 'en');
        $this->yyb = jdate('Y', '', '', '', 'en');
        $this->test_year = jdate('Y-m-d', '', '', '', 'en');
        $this->task_dos = Task_do::all();
        $this->tasks = Task::where('title', 'like', '%' . $this->filter . '%')->orderby('id', 'desc')->get();
        $this->year = jdate('Y', '', '', '', 'en');

        $this->tt = jmktime('', '', '', '$this->d', '$this->m', '$this->year');
        $this->set();
    }
    public function set(): void
    {
        if ($this->month > 6 and $this->month <= 12) {
            $this->ld = 30;
        } else {
            $this->ld = 31;
        }

    }

    public function loadusers(): void
    {
        $this->users = User::all();
    }

    public function mount()
    {
        $this->get_task();

    }

    public function edit($taskId)
    {
        $task = Task::find($taskId);
        if (!$task) {
            return;
        }

        $task->approved = $task->approved === 0 ? 1 : 0;
        $task->save();

        $this->get_task();
//        $this->resetExcept('tasks', 'year', 'yyb', 'day', 'month');
    }

    public function store()
    {
        $this->validate([
            'user_id' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'title' => 'required|string|min:2',
            'status' => 'required',
            'description' => 'required|string|min:2',
        ]);
        $t = new Task();
        $t->user_id = $this->user_id;
        $t->year = $this->year;
        $t->month = $this->month;
        $t->day = $this->day;
        $t->title = $this->title;
        $t->status = $this->status;
        $t->description = $this->description;
        $t->deadline = $this->year . '-' . $this->month . '-' . $this->day;
        if (jcheckdate($this->month, $this->day, $this->year) == true) {
            $t->save();
            $this->get_task();
            $this->resetExcept('tasks', 'year','users','ld','month','day','yyb','task_user');
            $this->resetValidation();
            $this->reset('payam');
        } else {
            $this->payam = "تاریخ وارد شده نامعتبر است.";
        }
    }

    public function cancel_store()
    {
        $this->resetExcept('tasks', 'year','users','ld');
        $this->resetValidation();
        $this->get_task();
    }

    public function edit_taskk(Task $task)
    {
        $this->editing = $task;
        $this->title = $task->title;
        $this->user_id = $task->user_id;
        $this->description = $task->description;
        $this->year = $task->year;
        $this->status = $task->status;
        $this->month = $task->month;
        $this->day = $task->day;
        $this->act = 'update';
    }

    public function update_task()
    {
        $this->validate([
            'user_id' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'title' => 'required|string|min:2',
            'description' => 'required|string|min:2',
            'status' => 'required',
        ]);
        $this->editing->title = $this->title;
        $this->editing->user_id = $this->user_id;
        $this->editing->description = $this->description;
        $this->editing->year = $this->year;
        $this->editing->month = $this->month;
        $this->editing->day = $this->day;
        $this->editing->deadline = $this->year . '-' . $this->month . '-' . $this->day;
        $this->editing->status = $this->status;
        if (jcheckdate($this->month, $this->day, $this->year) == true) {
            $this->editing->save();
            $this->resetExcept('year', 'tasks','users','ld','yyb');
            $this->get_task();
            $this->resetValidation();
            $this->reset('act');
            $this->reset('payam');
        } else {
            $this->payam = "تاریخ وارد شده نامعتبر است.";
        }
    }

    public function cancel_update()
    {
        $this->reset('editing');
        $this->reset('act');
        $this->resetExcept('tasks', 'year','ld','yyb');
        $this->get_task();
    }

    public function zaman(Task $task)
    {
        $this->today =  jdate('Y-m-d');
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
            $this->day_mandeh = 'زمان مقرر به پایان رسیده است.';
        }
    }

    public function fil()
    {
        $this->get_task();
    }

    public function cancel_fil()
    {
        $this->reset('filter');
        $this->get_task();
    }

    public function amalkard()
    {
            $this->bishtarin_task = "کارهای تایید شده " . Task::where('user_id', $this->task_user)
                ->where('approved', 1)
                ->count();

            $this->kamtarin_task = "کارهای تایید نشده " . Task::where('user_id',$this->task_user)
                ->where('approved', 0)
                ->count();

            $this->total_task = "همه کارها " . Task::where('user_id',$this->task_user)
                ->count();
    }


}; ?>

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

            @foreach (\App\Models\User::all() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach

        </select>
        <button type="button" class="btn btn-outline-dark" wire:click="amalkard()">{{__('عملکرد کاربر')}}</button>

        <div>

            <span style="color:blue">{{$total_task}}</span>
            <span style="color:green">{{$bishtarin_task}}</span>
            <span style="color: red">{{$kamtarin_task}}</span>

        </div>
    </div>
    {{--    span--}}
    <span style="" class="myspan">  {{jdate('Y-m-d')}}</span><br>

    {{--    start form--}}
    <div class="myform">
        <input type="text" wire:model="title" placeholder="عنوان">
        @error('title')
        {{$message}}
        @enderror
        <input type="text" wire:model="description" placeholder="شرح">
        @error('description')
        {{$message}}
        @enderror
        <select wire:model="user_id">
            <option  value="">انتخاب کاربر...</option>
            @foreach (\App\Models\User::all() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')
        {{$message}}
        @enderror
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
        <select wire:model="status">
            <option  value="">انتخاب اولویت...</option>
            <option value="1">{{__('بیشتر')}}</option>
            <option value="2">{{__('کمتر')}}</option>
        </select>
        @error('status')
        {{$message}}
        @enderror

        @if($act=='create')
            <button type="button" class="btn btn-outline-success" wire:click="store">{{__('ثبت')}}</button>

        @else
            <button type="button" class="btn btn-outline-success" wire:click="update_task">{{__('ویرایش')}}</button>
            <button type="button" class="btn btn-outline-danger" wire:click="cancel_update">{{__('لغو')}}</button>

        @endif
        <span style="color: red">{{$payam}}</span>

    </div>


    {{--end form--}}


    <div class="search">
        <input type="text" wire:model="filter" placeholder="جستجو">
        <button type="button" class="btn btn-success" wire:click="fil">جستجو</button>
        {{--        <button type="submit" class="btn btn-danger" wire:click="cancel_fil">لغو جستجو</button>--}}
    </div>


    <table class="mytable">

        <tr>
            <th>{{__('شناسه')}}</th>
            <th>{{__('شناسه_نام کاربر')}}</th>
            <th>{{__('عنوان')}}</th>
            <th>{{__('شرح')}}</th>
            <th>{{__('موعد مقرر')}}</th>
            <th>{{__('تاریخ انجام')}}</th>
            <th>{{__('اولویت')}}</th>
            <th>{{__('تایید مدیر')}}</th>
            <th>{{__('.....')}}</th>
        </tr>
        @foreach($tasks as $task)
            <tr>
                <td>{{$task->id}}</td>
                <td>
                    {{$task->user_id}}
                    {{__('_')}}
                    @foreach (\App\Models\User::where('id', $task->user_id)->get() as $user)
                        {{$user->name}}
                    @endforeach
                </td>
                <td>{{$task->title}}</td>
                <td>{{$task->description}}</td>
                <td style="background-color:@foreach (\App\Models\Task_do::where('task_id', $task->id)->get() as $task_do)
                        @if(test_date($task->deadline, $task_do->date_do))
                            {{__('lightgreen')}}
                        @else
                            {{__('orange')}}
                        @endif
                    @endforeach"
                >{{$task->deadline}}
                </td>
                <td style="background-color:@foreach (\App\Models\Task_do::where('task_id', $task->id)->get() as $task_do)
                        @if(test_date($task->deadline, $task_do->date_do))
                            {{__('lightgreen')}}
                        @else
                            {{__('orange')}}
                        @endif
                    @endforeach">

{{--                                        @foreach (\App\Models\Task_do::where('task_id', $task->id)->get() as $task_do)--}}
{{--                                            @if($task_do)--}}
{{--                                                {{$task_do->date_do}}--}}
{{--                                            @else--}}
{{--                                                {{__('نتبجه ایی  یافت نشد...')}}--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
                    @if($task->taskDos && count($task->taskDos) > 0)
                        @foreach($task->taskDos as $taskDo)
                            {{ $taskDo->date_do }}
                        @endforeach
                    @else
                        تاریخ انجام ثبت نشده
                    @endif
                </td>
                <td>
                    @if($task->status == '1')
                        {{__('بیشتر')}}
                    @else
                        {{__('کمتر')}}
                    @endif
                </td>
                <td style="background-color:@if($task->approved == 1){{__('lightgreen')}}@endif
                ;font-size: 15px;color:@if($task->approved == 0){{__('red')}}@endif">
                    @if($task->approved == 1)
                        {{__('تایید شد.')}}
                    @else
                        {{__('تایید نشد.')}}
                    @endif
                </td>
                <td>
                    <input type="checkbox" name="{{$task->id}}"
                           @if($task->approved == 1)
                               checked
                           @endif
                           wire:click="edit({{$task->id}})" >

                    <button type="button" class="btn btn-light"
                            wire:click="edit_taskk({{$task}})">{{__('ویرایش')}}</button>
                    <button type="button" class="btn btn-light"
                            wire:click="zaman({{$task}})">{{__('روز های باقی مانده')}}</button>
                    <span style="color:@if($day_mandeh>0)
                                {{__('red')}}
                           @else
                            {{__('green')}}
                             @endif">
                        @if($test_id == $task->id && $day_mandeh<0)
                            {{-$day_mandeh}}
                        @endif
                        @if($test_id == $task->id && $day_mandeh>0)
                            {{$day_mandeh}}
                        @endif
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
</div>
