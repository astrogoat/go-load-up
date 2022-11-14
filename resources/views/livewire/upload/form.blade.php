@push('styles')
    <link href="{{ asset('vendor/go-load-up/css/go-load-up.css') }}" rel="stylesheet">
@endpush

<x-fab::layouts.page
    title="Zipcode Upload"
    :breadcrumbs="[
            ['title' => 'Home', 'url' => route('lego.dashboard')],
            ['title' => 'Zip Codes', 'url' => route('lego.go-load-up.index')],
            ['title' => 'Zip code upload' ],

        ]"
    x-data="file"
>

    <x-fab::layouts.main-with-aside>
        <x-fab::layouts.panel>
            <form wire:submit.prevent="uploadData">
                <input wire:model="file" id="file" type="file" accept=".csv" required/>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">Upload</button>
            </form>

        </x-fab::layouts.panel>

    </x-fab::layouts.main-with-aside>
</x-fab::layouts.page>


