{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
<div
    class="notifications max-w-5xl mx-auto p-[var(--spacing-md)]  text-[var(--color-text-primary)] rounded-[var(--radius-md)] shadow-[var(--shadow-md)]">
    <div class="notifications__header mb-[var(--spacing-md)]">
        <h3 class="text-[var(--font-size-lg)] font-[var(--font-weight-bold)]">{{ __('messages.user_notifications') }}</h3>
    </div>

    <div class="notifications__search mb-[var(--spacing-md)]">
        <input type="text" wire:model.live="search" placeholder="{{ __('messages.search_notifications') }}"
               class="w-full p-2 border border-[var(--color-border)] rounded-[var(--radius-sm)] text-[var(--font-size-md)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
    </div>

    <div class="notifications__list">
        @forelse($notifications as $notification)
            <div
                class="notification-preview {{ $notification->unread() ? 'notification-preview--unread' : '' }} mb-[var(--spacing-md)] p-4 bg-[var(--color-background-alt)] rounded-[var(--radius-sm)] flex items-center justify-between">
                <div class="notification-preview__content flex items-center gap-4">
                   
                    <div>
                        <h4 class="notification-preview__name text-[var(--font-size-md)] font-[var(--font-weight-semibold)]">
                            {{ $notification->data['title'] }}
                        </h4>
                        <p class="notification-preview__excerpt text-[var(--font-size-md)]">
                            {{ $notification->data['message'] }}
                        </p>
                        <span
                            class="notification-preview__time text-[var(--font-size-sm)]">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @if($notification->unread())
                    <button wire:click="markAsRead('{{ $notification->id }}')"
                            class="text-[var(--color-success)] cursor-pointer">
                        {{ __('messages.mark_as_read') }}
                    </button>
                @endif
            </div>
        @empty
            <p class="text-[var(--color-text-secondary)]">{{ __('messages.no_notifications_found') }}</p>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('showSuccess', ({message}) => {
            Swal.fire({
                icon: 'success',
                title: '{{ __('messages.success') }}',
                text: message,
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

        Livewire.on('showError', ({message}) => {
            Swal.fire({
                icon: 'error',
                title: '{{ __('messages.error') }}',
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'bg-[var(--color-error-light)] text-[var(--color-text-primary)]',
                }
            });
        });
    });
</script>
