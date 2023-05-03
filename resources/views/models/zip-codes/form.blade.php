<x-fab::layouts.page
    title="{{ $model->name ?: 'Untitled' }}"
    :breadcrumbs="[
        ['title' => 'Go Load Up'],
        ['title' => 'Zip codes', 'url' => route('lego.go-load-up.zip-codes.index')],
        ['title' => $model ? $model->zip . ' (' . $model->name . ')' : 'New Zip Code' ],
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
            <div class="flex gap-4 w-full">
                <x-fab::forms.input
                    label="Zip code"
                    wire:model="model.zip"
                />
                <x-fab::forms.input
                    label="Name"
                    wire:model="model.name"
                    class="flex-1"
                />
            </div>

            <x-fab::forms.checkbox
                label="Zip code is eligible"
                wire:model="model.is_eligible"
                help="If checked, the zip code is eligible for White Glove Services."
            />

            <x-fab::forms.checkbox
                label="Zip code is located in California"
                wire:model="model.is_california"
                help="If checked, the zip code is a Californian zip code."
            />
        </x-fab::layouts.panel>

        <x-slot name="aside"></x-slot>

    </x-fab::layouts.main-with-aside>
    @push('styles')
        <link href="{{ asset('vendor/go-load-up/css/go-load-up.css') }}" rel="stylesheet">
    @endpush
</x-fab::layouts.page>
