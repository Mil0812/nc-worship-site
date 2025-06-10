<section class="tutorial" aria-labelledby="tutorial-heading">
    <header class="show-page-header">
        <h1 id="tutorial-heading">
            {{ $selectedTutorial->song->name }}
        </h1>
    </header>

    <div class="tutorial__instruments flex justify-center gap-[var(--spacing-md)] mb-[var(--spacing-lg)]">
        @foreach ($tutorials as $tutorial)
            <button
                wire:click="selectTutorial('{{ $tutorial['slug'] }}')"
                class="tutorial__instrument {{ $tutorial['slug'] === $slug ? 'tutorial__instrument--active' : '' }}"
                aria-label="{{ str_replace('{instrument_name}', $tutorial['instrument_name'], __('messages.switch_to_instrument_tutorial')) }}"
                title="{{ $tutorial['instrument_name'] }}"
                {{ $tutorial['instrument_name'] === 'Unknown' ? 'disabled' : '' }}>
                <img
                    src="{{ $tutorial['icon'] ? Storage::url($tutorial['icon']) : asset('default-images/example-musical-instrument.png') }}"
                    alt="{{ str_replace('{instrument_name}', $tutorial['instrument_name'], __('messages.instrument_icon_alt')) }}"
                    class="w-[32px] h-[32px]"
                    loading="lazy">
            </button>
        @endforeach
    </div>

    <div class="tutorial__video max-w-[800px] mx-auto mb-[var(--spacing-xl)]">
        <div class="relative w-full" style="padding-bottom: 56.25%;">
            <iframe
                id="tutorial-video"
                src="{{ $selectedTutorial->video }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                class="absolute top-0 left-0 w-full h-full"
                title="{{ str_replace(['{song_name}', '{instrument_name}', '{author}'], [$selectedTutorial->song->name, $selectedTutorial->instrument?->name ?? __('messages.unknown'), $selectedTutorial->song->author], __('messages.tutorial_video_title')) }}">
            </iframe>
        </div>
    </div>

    <div class="tutorial__description max-w-[800px] mx-auto">
        <p class="text-[var(--font-size-md)] text-center">
            {{ $selectedTutorial->description ?: str_replace(['{song_name}', '{instrument_name}', '{author}'], [$selectedTutorial->song->name, $selectedTutorial->instrument?->name ?? __('messages.unknown'), $selectedTutorial->song->author], __('messages.default_tutorial_description')) }}
        </p>
    </div>
    <x-comments-section :comments="$comments" :component="$this"/>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('update-video', ({url, slug}) => {
                const iframe = document.getElementById('tutorial-video');
                if (iframe) {
                    iframe.src = url;
                    window.history.pushState({}, document.title, `/tutorials/${slug}`);
                }
            });

            Livewire.on('showSuccess', ({message}) => {
                Swal.fire({
                    icon: 'success',
                    title: '{{ __('messages.js_success_title') }}',
                    text: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-[var(--color-success)] text-[var(--color-text-primary)]',
                    }
                });
            });

            Livewire.on('showError', ({message}) => {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('messages.js_error_title') }}',
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

            Livewire.on('confirmCommentDeletion', ({commentId}) => {
                Swal.fire({
                    title: '{{ __("messages.are_you_sure") }}',
                    text: '{{ __("messages.delete_comment_confirmation") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--color-error)',
                    cancelButtonColor: 'var(--color-text-secondary)',
                    confirmButtonText: '{{ __("messages.yes_delete") }}',
                    cancelButtonText: '{{ __("messages.cancel") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.
                        deleteComment(commentId);
                    }
                });
            });
        });
    </script>
</section>
