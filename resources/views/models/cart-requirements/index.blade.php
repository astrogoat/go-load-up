<x-fab::layouts.page
    title="Cart requirements"
    description="List of services that have cart requirements associated with them"
    :breadcrumbs="[
        ['title' => 'Go Load Up'],
        ['title' => 'Cart requirements', 'url' => route('lego.go-load-up.cart-requirements.index')],
    ]"
    x-data="{ showColumnFilters: false }"
>
    <x-slot name="actions">
        <x-fab::elements.button type="link" :url="route('lego.go-load-up.cart-requirements.create')">
            <x-fab::elements.icon :icon="\Helix\Fabrick\Icon::PENCIL_ALT" class="h-5 w-5 mr-2" />
            <span>New requirement</span>
        </x-fab::elements.button>
    </x-slot>

    @include('lego::models._includes.indexes.filters')

    <x-fab::lists.table>
        <x-slot name="headers">
            @include('lego::models._includes.indexes.headers')
            <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
        </x-slot>

        @include('lego::models._includes.indexes.header-filters')
        <x-fab::lists.table.header x-show="showColumnFilters" x-cloak class="bg-gray-100" />

        @foreach($models as $requirement)
            <x-fab::lists.table.row :odd="$loop->odd">
                @if($this->shouldShowColumn('title'))
                    <x-fab::lists.table.column primary full>
                        <a href="{{ route('lego.go-load-up.cart-requirements.edit', $requirement) }}">{{ $requirement->title }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('updated_at'))
                    <x-fab::lists.table.column align="right">
                        {{ $requirement->updated_at->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endif

                <x-fab::lists.table.column align="right" slim>
                    <a href="{{ route('lego.go-load-up.cart-requirements.edit', $requirement) }}">Edit</a>
                </x-fab::lists.table.column>
            </x-fab::lists.table.row>
        @endforeach
    </x-fab::lists.table>

    @include('lego::models._includes.indexes.pagination')
</x-fab::layouts.page>
