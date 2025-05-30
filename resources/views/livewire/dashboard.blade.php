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
    public $task_id;
    public $year;
    public $e_year;
    public $month;
    public $day;
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

    public function login(Request $req)
    {
        $mobile = $req->input('mobile');
        $password = $req->input('password');

    $check= DB::table('users')->where(['mobile' => $mobile, 'password' => $password])->get();

        if (count($check ) > 0) {
           return "page";

        } else {
            // echo "Login Failed!";
            return Redirect::route('login')->with(['error' => "Invalid mobile or Password!!"]);
        }
    }

    public function mount()
    {
        $this->get_task();

    }

    public function get_task()
    {
        $this->task_id = \App\Models\Task::where('user_id', Auth::id())->orderby('id', 'desc')->get();
        $this->taskDos = \App\Models\Task_do::where('user_id', Auth::id())->get();
        $this->year = jdate('Y', '', '', '', 'en');
    }

    public function store()
    {
        $this->validate([

            'e_year' => 'required|numeric',
            'month' => 'required|numeric|between:1,12',
            'day' => 'required|numeric|between:1,31',

        ]);
        $t_d = new Task_do();
        $t_d['task_id'] = $this->task_id;
        $t_d['user_id'] = Auth::id();
        $t_d['year'] = $this->e_year;
        $t_d['month'] = $this->month;
        $t_d['day'] = $this->day;
        $t_d['date_do'] = $this->e_year . '-' . $this->month . '-' . $this->day;
        if (jcheckdate($this->month, $this->day, $this->e_year) == true) {
            $t_d->save();
            $this->get_task();
            $this->test = $t_d['date_do'];
            $this->resetValidation();
            $this->resetExcept('year', 'selectedTaskId ');
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
        $this->act = 'edit';
        $this->edit_date = $taskDo;
        $this->e_year = $taskDo['year'];
        $this->month = $taskDo['month'];
        $this->day = $taskDo['day'];
    }

    public function update_date()
    {
        $this->validate([
            'e_year' => 'required|numeric',
            'month' => 'required|numeric|between:1,12',
            'day' => 'required|numeric|between:1,31',
        ]);

        $this->edit_date['date_do'] = $this->e_year . '-' . $this->month . '-' . $this->day;
        $this->edit_date['year'] = $this->e_year;
        $this->edit_date['month'] = $this->month;
        $this->edit_date['day'] = $this->day;
        if (jcheckdate($this->month, $this->day, $this->e_year) == true) {
            $this->edit_date->save();
            $this->reset('act');
            $this->resetValidation();
            $this->get_task();
            $this->resetExcept('year', 'selectedTaskId');
        } else {
            $this->payam = "تاریخ وارد شده نامعتبر است.";
        }
    }

    public function cancel_update()
    {
        $this->reset('act');
        $this->reset('payam');

    }
    public function amalkard(){

        $this->bishtarin_task ="کارهای تایید شده" .Task::where('user_id', Auth::user()->id)->where( 'approved','true')->count();
        $this->kamtarin_task = "کارهای تایید نشده".Task::where('user_id', Auth::user()->id)->where( 'approved','false')->count();
        $this->total_task = "همه کارها".Task::where('user_id', Auth::user()->id)->count();


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


        <h4 style="color: red">
            @if(Auth()->user()->hasrole('admin'))
                <span >{{__("ادمین")}}</span>

            @endif

            {{ Auth::user()->name}}___
            <span style="color: black">
                 {{ Auth::user()->mobile}}
                </span>
                <span  class="myspan">{{__("داشبورد")}}</span>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <input type="submit" value="خروج">
            </form>

        </h4>
           <a href="{{route('task_do')}}">{{__("کارهای من")}}</a>
        @if(Auth()->user()->hasrole('admin'))

        <a href="{{route('tasks')}}">{{__("افزودن کارها")}}</a>


        @endif
    @endguest

</div>

