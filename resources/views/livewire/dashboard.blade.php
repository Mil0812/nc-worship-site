{{-- Be like water. --}}

<div
    class="profile max-w-5xl mx-auto p-[var(--spacing-md)]  text-[var(--color-text-primary)] rounded-[var(--radius-md)] shadow-[var(--shadow-md)]">
    <div class="profile__header flex flex-col items-center gap-[var(--spacing-md)]">
        <div class="avatar-container relative">
            @if($user->avatar)
                <div class="relative">
                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}'s avatar"
                         class="w-24 h-24 rounded-full object-cover border-2 border-[var(--color-primary)]">
                    <button type="button"
                            onclick="confirmRemoveAvatar()"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                            title="{{ __('Remove avatar') }}">
                        <span class="sr-only">{{ __('Remove avatar') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @elseif($new_avatar)
                <div class="relative">
                    <img src="{{ $new_avatar->temporaryUrl() }}" alt="Avatar preview"
                         class="w-24 h-24 rounded-full object-cover border-2 border-[var(--color-primary)]">
                    <button type="button"
                            wire:click="$set('new_avatar', null)"
                            class="absolute -top-2 -right-2 var(--color-error) text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                            title="{{ __('Cancel') }}">
                        <span class="sr-only">{{ __('Cancel') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @else
                <div
                    class="w-24 h-24 rounded-full bg-[var(--color-primary-light)] flex items-center justify-center text-[var(--color-primary)] font-[var(--font-weight-bold)]">
                    {{ $user->initials() }}
                </div>
            @endif

            <div class="mt-2 flex flex-col items-center">
                <input type="file" wire:model.live="new_avatar" id="avatar-upload" class="hidden" accept="image/*"/>
                <label for="avatar-upload"
                       class="cursor-pointer text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] text-sm">
                    {{ __('Change avatar') }}
                </label>
                @error('new_avatar') <span class="var(--color-error) text-xs">{{ $message }}</span> @enderror

                @if($new_avatar)
                    <button type="button"
                            wire:click="updateAvatar"
                            class="mt-2 px-3 py-1 bg-[var(--color-primary)] text-white rounded-[var(--radius-sm)] text-sm">
                        {{ __('Save') }}
                    </button>
                @endif
            </div>
        </div>

        <div class="profile__name text-center">
            <h1 class="text-[var(--font-size-2xl)] font-[var(--font-weight-bold)]">{{ $user->name }} {{ $user->last_name }}</h1>
            <p class="text-[var(--font-size-md)]">{{ $user->email }}</p>
            @if ($user->telegram_id)
                <p class="text-[var(--font-size-md)]">{{ __('messages.telegram_id') }}: {{ $user->telegram_id }}</p>
            @else
                <p class="text-[var(--font-size-md)]">{{ __('messages.telegram_not_set') }}</p>
            @endif
        </div>
    </div>

    <section class="mt-[var(--spacing-lg)]">
        <livewire:settings.profile/>
    </section>

    <div class="profile__bands mt-[var(--spacing-lg)]">
        <h2 class="text-[var(--font-size-xl)] font-[var(--font-weight-bold)] mb-[var(--spacing-sm)]">{{ __('messages.your_bands') }}</h2>
        @forelse ($bands as $band)
            <a href="{{ route('bands.show', $band->id) }}" wire:navigate
               class="block text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] transition-[var(--transition-normal)] py-[var(--spacing-xs)]">
                {{ $band->name }}
            </a>
        @empty
            <p class="text-[var(--color-text-secondary)]">{{ __('messages.no_bands') }}</p>
        @endforelse
    </div>
</div>

<script>
    function confirmRemoveAvatar() {
        Swal.fire({
            title: '{{ __('Are you sure?') }}',
            text: '{{ __('Do you want to remove your avatar?') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--color-error)',
            cancelButtonColor: 'var(--color-text-secondary)',
            confirmButtonText: '{{ __('Yes, remove it!') }}',
            cancelButtonText: '{{ __('Cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('removeAvatar');
            }
        });
    }

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
