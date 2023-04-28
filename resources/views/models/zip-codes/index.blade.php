@extends('lego::layouts.lego')

@section('content')
    <x-fab::layouts.page
        title="Zip codes"
        :breadcrumbs="[
            ['title' => 'Go Load Up'],
            ['title' => 'Zip codes', 'url' => route('lego.go-load-up.zip-codes.index')],
        ]"
    >
        <x-slot name="actions">
            <x-fab::elements.button type="link" :url="route('lego.go-load-up.zip-codes.upload')">Upload Zip Codes</x-fab::elements.button>
        </x-slot>

        <x-fab::lists.table  class="mt-8">
            <x-slot name="headers">
                <x-fab::lists.table.header>Zip</x-fab::lists.table.header>
                <x-fab::lists.table.header>Name</x-fab::lists.table.header>
                <x-fab::lists.table.header>Eligibility</x-fab::lists.table.header>
                <x-fab::lists.table.header>Last updated</x-fab::lists.table.header>
                <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
            </x-slot>

            @foreach($zipCodes as $zipCode)
                <x-fab::lists.table.row :odd="$loop->odd">
                    <x-fab::lists.table.column full primary>
                        <a href="{{ route('lego.go-load-up.zip-codes.edit', $zipCode) }}">{{ $zipCode->zip }}</a>
                    </x-fab::lists.table.column>
                    <x-fab::lists.table.column >
                        <a href="{{ route('lego.go-load-up.zip-codes.edit', $zipCode) }}">{{ $zipCode->name }}</a>
                    </x-fab::lists.table.column>
                    <x-fab::lists.table.column >
                        {{ $zipCode->isEligible() ? 'Eligible' : 'Ineligible' }}
                    </x-fab::lists.table.column>
                    <x-fab::lists.table.column
                        align="right">{{ $zipCode->updated_at->toFormattedDateString() }}</x-fab::lists.table.column>
                    <x-fab::lists.table.column align="right" slim>
                        <a href="{{ route('lego.go-load-up.zip-codes.edit', $zipCode) }}">Edit</a>
                    </x-fab::lists.table.column>
                </x-fab::lists.table.row>
            @endforeach
        </x-fab::lists.table>

        <div class="pt-6">
            {{ $zipCodes->links() }}
        </div>
    </x-fab::layouts.page>
@endsection

@push('styles')
    <link href="{{ asset('vendor/go-load-up/css/go-load-up.css') }}" rel="stylesheet">
@endpush
