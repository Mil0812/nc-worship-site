<?php

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $last_name = '';
    public string $email = '';
    public string $telegram_id = '';
    public bool $receive_notifications = true;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->last_name = $user->last_name ?? '';
        $this->email = $user->email;
        $this->telegram_id = $user->telegram_id ?? '';
        $this->receive_notifications = $user->receive_notifications ?? true;

    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
            'telegram_id' => ['nullable', 'string', 'max:255', 'regex:/^@.*/'],
            'receive_notifications' => ['boolean'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name, last_name: $user->last_name);
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
};

?>

<section class="w-full max-w-5xl mx-auto p-[var(--spacing-md)]">
    <div class="mb-[var(--spacing-md)]">
        <h3 class="text-[var(--font-size-lg)] font-[var(--font-weight-bold)]">{{ __('messages.profile') }}</h3>
        <p class="text-[var(--font-size-md)]">{{ __('messages.update_profile') }}</p>
    </div>
    <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
        <flux:input wire:model="name" :label="__('messages.name')" type="text" required autofocus autocomplete="name"/>
        <flux:input wire:model="last_name" :label="__('messages.last_name')" type="text" autocomplete="family-name"/>
        <div>
            <flux:input wire:model="email" :label="__('messages.email')" type="email" required autocomplete="email"/>
            @if (auth()->user() instanceof MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <flux:text class="mt-4">
                        {{ __('messages.your_email_unverified') }}
                        <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                            {{ __('messages.resend_verification') }}
                        </flux:link>
                    </flux:text>
                    @if (session('status') === 'verification-link-sent')
                        <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                            {{ __('messages.verification_link_sent') }}
                        </flux:text>
                    @endif
                </div>
            @endif
        </div>
        {{--        <flux:input wire:model="telegram_id" :label="__('messages.telegram_id')" type="text" autocomplete="telegram"/>--}}

        {{--        @if($telegram_id)--}}
        {{--            <div class="mt-2 text-sm text-var(--color-text-primary)">--}}
        {{--                {{ __('messages.telegram_instructions') }}--}}

        {{--                <div class="mt-2 flex flex-col gap-2">--}}

        {{--                    <a href="https://t.me/{{ ltrim(config('services.telegram-bot-api.bot_username'), '@') }}"--}}
        {{--                       target="_blank" class="inline-flex items-center text-indigo-900 hover:text-indigo-700">--}}
        {{--                        <span>{{ __('messages.open_in_browser') }}: {{ config('services.telegram-bot-api.bot_username') }}</span>--}}
        {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"--}}
        {{--                             stroke="currentColor">--}}
        {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
        {{--                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>--}}
        {{--                        </svg>--}}
        {{--                    </a>--}}

        {{--                    <div>--}}
        {{--                        <a href="#" onclick="showQRCode(); return false;" class="text-indigo-900 hover:text-indigo-700">--}}
        {{--                            {{ __('messages.show_qr_code') }}--}}
        {{--                        </a>--}}
        {{--                        <div id="qrcode-container"--}}
        {{--                             class="hidden mt-2 p-2] "></div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--            <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>--}}
        {{--            <script>--}}
        {{--                function showQRCode() {--}}
        {{--                    const container = document.getElementById('qrcode-container');--}}
        {{--                    container.classList.toggle('hidden');--}}

        {{--                    if (!container.innerHTML) {--}}
        {{--                        const botUsername = '{{ ltrim(config('services.telegram-bot-api.bot_username'), '@') }}';--}}
        {{--                        const url = 'https://t.me/' + botUsername;--}}

        {{--                        const qr = qrcode(0, 'M');--}}
        {{--                        qr.addData(url);--}}
        {{--                        qr.make();--}}

        {{--                        container.innerHTML = qr.createImgTag(5);--}}
        {{--                    }--}}
        {{--                }--}}
        {{--            </script>--}}
        {{--        @endif--}}

        <div class="flex items-center gap-4">
            <input wire:model="receive_notifications" id="receive_notifications" type="checkbox"
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="receive_notifications" class="ml-2 block text-sm text-gray-900">
                {{ __('messages.receive_notifications') }}</label>
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit"
                             class="w-full bg-[var(--color-primary)] text-[var(--color-text-primary)] hover:bg-[var(--color-primary-dark)] rounded-[var(--radius-sm)] ">{{ __('messages.save') }}</flux:button>
            </div>
            <x-action-message class="me-3" on="profile-updated">
                {{ __('messages.saved') }}
            </x-action-message>
        </div>
    </form>
</section>
