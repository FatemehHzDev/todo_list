<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.base')] class extends Component {
    #[Validate('required|string')]
    public string $mobile = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['mobile' => $this->mobile, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'mobile' => __('auth.failed'),
            ]);
        }
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'mobile' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }
    protected function throttleKey(): string
    {
        return Str::transliterate($this->mobile.'|'.request()->ip());
    }
}; ?>

{{--<div>--}}
{{--    <input type="text" wire:model="mobile" placeholder="mobile">--}}
{{--    @error('mobile')--}}
{{--    {{$message}}--}}
{{--    @enderror--}}
{{--    <input type="text" wire:model="password" placeholder="password">--}}
{{--    @error('password')--}}
{{--    {{$message}}--}}
{{--    @enderror--}}
{{--    @error('credentials')--}}
{{--    {{$message}}--}}
{{--    @enderror--}}
{{--    <button type="submit" wire:click="login">save</button>--}}
{{--</div>--}}
<div class="mycontainer pt-3">
    <h3 class="header">ورود</h3>
    <input type="text" wire:model="mobile" placeholder="موبایل" class="myinput">
    @error('mobile')
    {{$message}}
    @enderror
    <input type="text" wire:model="password" placeholder="رمز عبور" class="myinput">
    @error('password')
    {{$message}}
    @enderror
    @error('credentials')
    {{$message}}
    @enderror
    <button type="submit" wire:click="login" class="btn btn-primary mx-auto d-block">ورود</button>

</div>
