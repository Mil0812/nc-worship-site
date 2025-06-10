<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div
    class="flex flex-col gap-[var(--spacing-lg)] max-w-md mx-auto p-[var(--spacing-md)] bg-[var(--color-background-alt)] rounded-[var(--radius-md)] shadow-md">
    <flux:text class="text-center text-[var(--font-size-md)]">
        {{ __('messages.verify_email_message') }}
    </flux:text>

    @if (session('status') == 'verification-link-sent')
        <flux:text
            class="text-center text-[var(--color-success)] font-[var(--font-weight-medium)]">
            {{ __('messages.new_verification_link_sent') }}
        </flux:text>
    @endif

    <div class="flex flex-col items-center gap-[var(--spacing-md)]">
        <flux:button wire:click="sendVerification" variant="primary"
                     class="w-full bg-[var(--color-primary)] text-[var(--color-text-light)] hover:bg-[var(--color-primary-dark)] transition-[var(--transition-normal)] rounded-[var(--radius-md)] py-[var(--spacing-sm)]">
            {{ __('messages.resend_verification_email') }}
        </flux:button>

        <flux:link
            class="text-[var(--font-size-sm)] dark:text-[var(--color-text-light)] hover:text-[var(--color-primary)] transition-[var(--transition-normal)] cursor-pointer"
            wire:click="logout">
            {{ __('messages.log_out') }}
        </flux:link>
    </div>
</div>
