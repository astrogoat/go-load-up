<x-fab::layouts.page
    title="{{ $model->name ?: 'Untitled' }}"
    :breadcrumbs="[
            ['title' => 'Home', 'url' => route('lego.dashboard')],
            ['title' => 'Zip Codes', 'url' => route('lego.go-load-up.zip-codes.index')],
            ['title' => $model->name ?: 'New Zip Code' ],
        ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')" {{-- For Mac --}}
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')" {{-- For PC  --}}
>
    <x-slot name="actions">
        @include('lego::models._includes.forms.page-actions')
    </x-slot>
    <x-fab::layouts.main-with-aside>
        <x-fab::layouts.panel>
            <x-fab::forms.input
                label="Zip Code"
                wire:model="model.zip"
            />

        </x-fab::layouts.panel>

        <x-fab::layouts.panel>
            <x-fab::forms.input
                label="Name"
                wire:model="model.name"
            />

            <x-fab::forms.checkbox
                label="Is California zip code"
                wire:model="model.is_california"
                help="If checked this indicates that this zip code is A California zip code."
            />

            <x-fab::forms.checkbox
                label="Should be enabled"
                wire:model="model.status"
                help="If checked, the zip code is eligible for White Glove Services. To make the zip code ineligible for White Glove, uncheck this box. The box is checked by default with the CSV file is added to Strata."
            />
        </x-fab::layouts.panel>

        <x-slot name="aside"></x-slot>

    </x-fab::layouts.main-with-aside>
    @push('styles')
        <link href="{{ asset('vendor/go-load-up/css/go-load-up.css') }}" rel="stylesheet">
    @endpush
</x-fab::layouts.page>
