<x-base-layout>
<div>

{{--    <div class="p-6 text-gray-900">--}}
{{--        {{ __("You're logged in!") }}--}}
{{--    </div>--}}
       @can('edit articles')
           You can EDIT ARTICLES.
           @endcan
         @can('publish articles')
            You can PUBLISH ARTICLES.
           @endcan
    @can('delete articles')
        You can delete ARTICLES.
    @endcan
        @can('only super-admins can see this section')
            Congratulations, you are a super-admin!
             @endcan

    <a href="{{route('login')}}" class="btn btn-primary d-block col-1 mx-auto my-1 btn-md ">{{__('ورود')}}</a>
    <a href="{{route('register')}}" class="btn btn-primary d-block col-1 mx-auto my-1 btn-md ">{{__('ثبت نام')}}</a>
{{--    <a href="{{route('tasks')}}">tasks</a>--}}
{{--    <a href="{{route('task_do')}}">user_task</a>--}}
</div>
</x-base-layout>
