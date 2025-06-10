<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('messages.auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('messages.confirm_password_title')"
        :description="__('messages.confirm_password_description')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')"/>

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('messages.password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('messages.password')"
        />

        <flux:button variant="primary" type="submit" class="w-full">{{ __('messages.confirm') }}</flux:button>
    </form>
</div>
