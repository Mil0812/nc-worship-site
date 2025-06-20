{{-- The best athlete wants his opponent at his best. --}}
<div
    class="profile max-w-3xl mx-auto p-[var(--spacing-xl)]  rounded-[var(--radius-md)] shadow-[var(--shadow-md)]">
    <div class="mb-[var(--spacing-md)] text-center">
        <h3 class="text-[var(--font-size-lg)] font-[var(--font-weight-bold)]">{{ __('messages.update_password') }}</h3>
        <p class="text-[var(--font-size-md)]">{{ __('messages.password_security') }}</p>
    </div>
    <form wire:submit="updatePassword" class="space-y-6">
        <div class="input-group">
            <label for="current_password"
                   class="block text-sm font-medium text-[var(--color-text-primary)]">{{ __('messages.current_password') }}</label>
            <input wire:model="current_password" id="current_password" type="password" required
                   autocomplete="current-password"
                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
        </div>
        <div class="input-group">
            <label for="password"
                   class="block text-sm font-medium text-[var(--color-text-primary)]">{{ __('messages.new_password') }}</label>
            <input wire:model="password" id="password" type="password" required autocomplete="new-password"
                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
        </div>
        <div class="input-group">
            <label for="password_confirmation"
                   class="block text-sm font-medium text-[var(--color-text-primary)]">{{ __('messages.confirm_password') }}</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                   autocomplete="new-password"
                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
        </div>
        <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-[var(--color-primary)] text-white rounded-[var(--radius-sm)] hover:bg-[var(--color-primary-dark)] transition-colors">
                {{ __('messages.save') }}
            </button>
            <x-action-message class="ml-4" on="password-updated">
                {{ __('messages.saved') }}
            </x-action-message>
        </div>
    </form>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('password-updated', () => {
            Swal.fire({
                icon: 'success',
                title: '{{ __('messages.success') }}',
                text: '{{ __('messages.saved') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'bg-[var(--color-success-light)] text-[var(--color-text-primary)]',
                }
            });
        });
    });
</script>
