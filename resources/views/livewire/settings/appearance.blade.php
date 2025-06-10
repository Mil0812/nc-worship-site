<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>


<section class="w-full max-w-5xl mx-auto p-[var(--spacing-md)]">
    @include('partials.dashboard-header')
    <div class="mb-[var(--spacing-md)]">
        <h3 class="text-[var(--font-size-lg)] font-[var(--font-weight-bold)]">{{ __('Appearance') }}</h3>
        <p class="text-[var(--font-size-md)]">{{ __('Customize your theme') }}</p>
    </div>

    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
        <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
        <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
        <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
    </flux:radio.group>

</section>
