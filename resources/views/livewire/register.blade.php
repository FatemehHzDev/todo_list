<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.base')] class extends Component {
    public string $mobile = '';
    public string $name = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name'=>['required', 'string','min:2'],
            'mobile' => ['required', 'string', 'digits:11','starts-with:09', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

{{--<div>--}}
{{--    <form wire:submit="register">--}}
{{--        <input type="text" wire:model="name" placeholder="name">--}}
{{--        @error('name')--}}
{{--        {{$message}}--}}
{{--        @enderror--}}
{{--        <input type="text" wire:model="mobile" placeholder="mobile">--}}
{{--        @error('mobile')--}}
{{--        {{$message}}--}}
{{--        @enderror--}}
{{--        <input type="text" wire:model="password" placeholder="password">--}}
{{--        @error('password')--}}
{{--        {{$message}}--}}
{{--        @enderror--}}
{{--        <input type="text" wire:model="password_confirmation" placeholder="password_confirmation">--}}
{{--        <input type="submit" value="save">--}}
{{--    </form>--}}
{{--</div>--}}
<div>
    <form wire:submit="register" class="mycontainer pt-3 ">
        <h3 class="header">ثبت نام</h3>
        <input type="text" wire:model="name" placeholder="نام" class="myinput">
        @error('name')
        {{$message}}
        @enderror
        <input type="text" wire:model="mobile" placeholder="موبایل"  class="myinput">
        @error('mobile')
        {{$message}}
        @enderror
        <input type="text" wire:model="password" placeholder="رمز عبور" class="myinput">
        @error('password')
        {{$message}}
        @enderror
        <input type="text" wire:model="password_confirmation" placeholder="تکرار رمز عبور" class="myinput" >
        <input type="submit" value="ثبت" class="d-block mx-auto btn btn-primary px-4">
    </form>
</div>
