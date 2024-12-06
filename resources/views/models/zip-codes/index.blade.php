<x-fab::layouts.page
    title="Zip codes"
    :breadcrumbs="[
        ['title' => 'Go Load Up'],
        ['title' => 'Zip codes', 'url' => route('lego.go-load-up.zip-codes.index')],
    ]"
    x-data="{ showColumnFilters: false }"
>
    <x-slot name="actions">
        <x-fab::elements.button type="link" :url="route('lego.go-load-up.zip-codes.upload')">Upload Zip Codes</x-fab::elements.button>
    </x-slot>

    @include('lego::models._includes.indexes.filters')

    <x-fab::lists.table  class="mt-8">
        <x-slot name="headers">
            @include('lego::models._includes.indexes.headers')
            <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
        </x-slot>

        @include('lego::models._includes.indexes.header-filters')
        <x-fab::lists.table.header x-show="showColumnFilters" x-cloak class="bg-gray-100" />

        @foreach($models as $zipCode)
            <x-fab::lists.table.row :odd="$loop->odd">
                @if($this->shouldShowColumn('zip'))
                    <x-fab::lists.table.column full primary>
                        <a href="{{ route('lego.go-load-up.zip-codes.edit', $zipCode) }}">{{ $zipCode->zip }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('name'))
                    <x-fab::lists.table.column >
                        <a href="{{ route('lego.go-load-up.zip-codes.edit', $zipCode) }}">{{ $zipCode->name }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('is_eligible'))
                    <x-fab::lists.table.column >
                        {{ $zipCode->isEligible() ? 'Eligible' : 'Ineligible' }}
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('updated_at'))
                    <x-fab::lists.table.column
                        align="right">{{ $zipCode->updated_at->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endif

                <x-fab::lists.table.column align="right" slim>
                    <a href="{{ route('lego.go-load-up.zip-codes.edit', $zipCode) }}">Edit</a>
                </x-fab::lists.table.column>
            </x-fab::lists.table.row>
        @endforeach
    </x-fab::lists.table>

    @include('lego::models._includes.indexes.pagination')

    @push('styles')
        <link href="{{ asset('vendor/go-load-up/css/go-load-up.css') }}" rel="stylesheet">
    @endpush
</x-fab::layouts.page>

