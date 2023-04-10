<x-fab::layouts.page
    :title="'Cart Checkbox Combinations'"
    :breadcrumbs="[
            ['title' => 'Home', 'url' => route('lego.dashboard')],
            ['title' => 'WG Product Match', 'url' => route('lego.go-load-up.product-match.index')],
{{--            ['title' => $model?->parentProduct?->title ?: 'Untitled'],--}}
        ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')"  For Mac
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')"  For PC
>
{{--    <x-slot name="actions">--}}
{{--        @include('lego::models._includes.forms.page-actions')--}}
{{--    </x-slot>--}}
    <x-lego::feedback.errors class="sh-mb-4" />

    <x-fab::layouts.main-with-aside>

        <x-fab::layouts.panel
            title="Combinations & Matching Products"
            description="Link White Glove products to this combination data"
            class="sh-mt-4"
            allow-overflow
            x-on:fab-added="$wire.call('selectProduct', $event.detail[1].key, 1)"
            x-on:fab-removed="$wire.call('unselectProduct', $event.detail[1].key, 1)"
        >
            @foreach($possibleCombinations as $combination)
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-gray-500 ">{{ $combination['label'] }}</div>
                    </div>
                    <div>
                        <x-fab::forms.combobox
                            :componentKey="$combination['code']"
                            :items="$this->getProductsForCollectionCombobox()"
                        ></x-fab::forms.combobox>

                        {{--                    <x-fab::lists.stacked--}}
                        {{--                        x-sortable="updateProductsOrder"--}}
                        {{--                        x-sortable.group="products"--}}
                        {{--                    >--}}
                        {{--                        --}}{{--                        @foreach($this->selectedOptionsOne as $product)--}}
                        {{--                        --}}{{--                            <div--}}
                        {{--                        --}}{{--                                x-sortable.products.item="{{ $product->id }}"--}}
                        {{--                        --}}{{--                            >--}}
                        {{--                        --}}{{--                                <x-fab::lists.stacked.grouped-with-actions--}}
                        {{--                        --}}{{--                                    :title="$product->title"--}}
                        {{--                        --}}{{--                                    :description="$product->type"--}}
                        {{--                        --}}{{--                                >--}}
                        {{--                        --}}{{--                                    <x-slot name="avatar">--}}
                        {{--                        --}}{{--                                        <div class="flex">--}}
                        {{--                        --}}{{--                                            <x-fab::elements.icon icon="dots-vertical" x-sortable.products.handle class="sh-h-5 sh-w-5 sh-text-gray-300 sh--mr-2" />--}}
                        {{--                        --}}{{--                                            <x-fab::elements.icon icon="dots-vertical" x-sortable.products.handle class="sh-h-5 sh-w-5 sh-text-gray-300 sh--ml-1.5" />--}}
                        {{--                        --}}{{--                                        </div>--}}
                        {{--                        --}}{{--                                    </x-slot>--}}
                        {{--                        --}}{{--                                    <x-slot name="actions">--}}
                        {{--                        --}}{{--                                        <x-fab::elements.button--}}
                        {{--                        --}}{{--                                            size="xs"--}}
                        {{--                        --}}{{--                                            type="link"--}}
                        {{--                        --}}{{--                                            :url="route('lego.products.edit', $product)"--}}
                        {{--                        --}}{{--                                        >--}}
                        {{--                        --}}{{--                                            View--}}
                        {{--                        --}}{{--                                        </x-fab::elements.button>--}}

                        {{--                        --}}{{--                                        <x-fab::elements.button--}}
                        {{--                        --}}{{--                                            size="xs"--}}
                        {{--                        --}}{{--                                            wire:click="unselectProduct({{ $product->id }}, 1)"--}}
                        {{--                        --}}{{--                                        >--}}
                        {{--                        --}}{{--                                            Remove--}}
                        {{--                        --}}{{--                                        </x-fab::elements.button>--}}
                        {{--                        --}}{{--                                    </x-slot>--}}
                        {{--                        --}}{{--                                </x-fab::lists.stacked.grouped-with-actions>--}}
                        {{--                        --}}{{--                            </div>--}}
                        {{--                        --}}{{--                        @endforeach--}}
                        {{--                    </x-fab::lists.stacked>--}}
                    </div>
                </div>
                <hr/>
            @endforeach

        </x-fab::layouts.panel>

    </x-fab::layouts.main-with-aside>
</x-fab::layouts.page>

@push('styles')
    <link href="{{ asset('vendor/shopify/css/go-load-up.css') }}" rel="stylesheet">
@endpush
