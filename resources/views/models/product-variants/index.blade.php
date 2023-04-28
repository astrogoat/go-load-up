@extends('lego::layouts.lego')

@push('styles')
    <link href="{{ asset('vendor/go-load-up/css/go-load-up.css') }}" rel="stylesheet">
@endpush

@section('content')
    <x-fab::layouts.page
        title="WG Product Match"
    >
        <x-slot name="actions">
            <x-fab::elements.button type="link" :url="route('lego.go-load-up.product-match.create')">Create</x-fab::elements.button>
        </x-slot>

        <x-fab::lists.table  class="mt-8">
            <x-slot name="headers">
                <x-fab::lists.table.header>Title</x-fab::lists.table.header>
                <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
            </x-slot>

            @foreach($productVariants as $variant)
                <x-fab::lists.table.row :odd="$loop->odd">
                    <x-fab::lists.table.column full primary>
                        <a href="{{ route('lego.go-load-up.product-match.edit', $variant) }}">{{ $variant->parentProduct?->title }}</a>
                    </x-fab::lists.table.column>
                    <x-fab::lists.table.column align="right" slim>
                        <a href="{{ route('lego.go-load-up.product-match.edit', $variant) }}">Edit</a>
                    </x-fab::lists.table.column>
                </x-fab::lists.table.row>
            @endforeach
        </x-fab::lists.table>

        <div class="pt-6">
            {{ $productVariants->links() }}
        </div>
    </x-fab::layouts.page>

@endsection
