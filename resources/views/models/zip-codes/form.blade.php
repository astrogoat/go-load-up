<x-fab::layouts.page
    title="{{ $model->name ?: 'Untitled' }}"
    :breadcrumbs="[
            ['title' => 'Home', 'url' => route('lego.dashboard')],
            ['title' => 'Zip Codes', 'url' => route('lego.go-load-up.index')],
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
                label="ELP"
                wire:model="model.elp"
                help="If checked this will allow search engines (i.e. Google or Bing) to index the page so it can be found when searching on said search engine."
            />

            <x-fab::forms.checkbox
                label="Should be enabled"
                wire:model="model.status"
                help="If checked this will allow search engines (i.e. Google or Bing) to index the page so it can be found when searching on said search engine."
            />
        </x-fab::layouts.panel>

        <x-slot name="aside"></x-slot>

    </x-fab::layouts.main-with-aside>
    @push('styles')
        <link href="{{ asset('vendor/go-load-up/css/go-load-up.css') }}" rel="stylesheet">
    @endpush
</x-fab::layouts.page>
