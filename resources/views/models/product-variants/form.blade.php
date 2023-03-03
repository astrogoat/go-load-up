<x-fab::layouts.page
    :title="$model?->parentProduct?->title ?: 'Untitled'"
    :breadcrumbs="[
            ['title' => 'Home', 'url' => route('lego.dashboard')],
            ['title' => 'WG Product Match', 'url' => route('lego.go-load-up.product-match.index')],
            ['title' => $model?->parentProduct?->title ?: 'Untitled'],
        ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')"  For Mac
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')"  For PC
>
    <x-slot name="actions">
        @include('lego::models._includes.forms.page-actions')
    </x-slot>
    <x-lego::feedback.errors class="sh-mb-4" />

    <x-fab::layouts.main-with-aside>
        <x-fab::layouts.panel>
            <x-fab::forms.select
                wire:model="model.parent_product_variant_id"
                wire:change="setErrorLabel"
                label="Parent Product Variant/Service"
                help="Choose a product variant for which you want to set rules. This will be used in the Cart page; when users attempt to proceed to checkout, the required products for each GoLoadUp services in the cart would be checked if they are available."
            >
                <option value="">-- Select GoLoadUp Product Variant --</option>
                @foreach($this->getVariantsOfDefaultProduct() as $variant)
                    <option value="{{ $variant->id }}">{{ $variant->title }}</option>
                @endforeach
            </x-fab::forms.select>
            <x-fab::forms.input
                label="Error Message"
                wire:model="model.error_message"
                help="Displays when a product is missing from one of the lists below."

            />
        </x-fab::layouts.panel>

        <div class="grid grid-cols-2 gap-4">
            <x-fab::layouts.panel
                title="Product Array 1"
                description="Link products to this parent product"
                class="sh-mt-4"
                allow-overflow
                x-on:fab-added="$wire.call('selectProduct', $event.detail[1].key, 1)"
                x-on:fab-removed="$wire.call('unselectProduct', $event.detail[1].key, 1)"
            >
                @if($model->exists)
                    <x-fab::forms.combobox
                        :componentKey="444444"
                        :items="$this->getProductsForCollectionCombobox1()"
                    ></x-fab::forms.combobox>

                    <x-fab::lists.stacked
                        x-sortable="updateProductsOrder"
                        x-sortable.group="products"
                    >
                        @foreach($this->selectedOptionsOne as $product)
                            <div
                                x-sortable.products.item="{{ $product->id }}"
                            >
                                <x-fab::lists.stacked.grouped-with-actions
                                    :title="$product->title"
                                    :description="$product->type"
                                >
                                    <x-slot name="avatar">
                                        <div class="flex">
                                            <x-fab::elements.icon icon="dots-vertical" x-sortable.products.handle class="sh-h-5 sh-w-5 sh-text-gray-300 sh--mr-2" />
                                            <x-fab::elements.icon icon="dots-vertical" x-sortable.products.handle class="sh-h-5 sh-w-5 sh-text-gray-300 sh--ml-1.5" />
                                        </div>
                                    </x-slot>
                                    <x-slot name="actions">
                                        <x-fab::elements.button
                                            size="xs"
                                            type="link"
                                            :url="route('lego.products.edit', $product)"
                                        >
                                            View
                                        </x-fab::elements.button>

                                        <x-fab::elements.button
                                            size="xs"
                                            wire:click="unselectProduct({{ $product->id }}, 1)"
                                        >
                                            Remove
                                        </x-fab::elements.button>
                                    </x-slot>
                                </x-fab::lists.stacked.grouped-with-actions>
                            </div>
                        @endforeach
                    </x-fab::lists.stacked>
                @else
                    <x-fab::feedback.alert type="info">
                        Please save the parent variant before you can attach products to it.
                    </x-fab::feedback.alert>
                @endif
            </x-fab::layouts.panel>
            <x-fab::layouts.panel
                title="Product Array 2"
                description="Link products to this parent product"
                class="sh-mt-4"
                allow-overflow
                x-on:fab-added="$wire.call('selectProduct', $event.detail[1].key, 2)"
                x-on:fab-removed="$wire.call('unselectProduct', $event.detail[1].key, 2)"
            >

                @if($model->exists)
                    <x-fab::forms.combobox
                        :componentKey="33"
                        :items="$this->getProductsForCollectionCombobox2()"
                    ></x-fab::forms.combobox>

                    <x-fab::lists.stacked
                        x-sortable="updateProductsOrder"
                        x-sortable.group="products"
                    >
                        @foreach($this->selectedOptionsTwo as $product)
                            <div
                                x-sortable.products.item="{{ $product->id }}"
                            >
                                <x-fab::lists.stacked.grouped-with-actions
                                    :title="$product->title"
                                    :description="$product->type"
                                >
                                    <x-slot name="avatar">
                                        <div class="flex">
                                            <x-fab::elements.icon icon="dots-vertical" x-sortable.products.handle class="sh-h-5 sh-w-5 sh-text-gray-300 sh--mr-2" />
                                            <x-fab::elements.icon icon="dots-vertical" x-sortable.products.handle class="sh-h-5 sh-w-5 sh-text-gray-300 sh--ml-1.5" />
                                        </div>
                                    </x-slot>
                                    <x-slot name="actions">
                                        <x-fab::elements.button
                                            size="xs"
                                            type="link"
                                            :url="route('lego.products.edit', $product)"
                                        >
                                            View
                                        </x-fab::elements.button>

                                        <x-fab::elements.button
                                            size="xs"
                                            wire:click="unselectProduct({{ $product->id }}, 2)"
                                        >
                                            Remove
                                        </x-fab::elements.button>
                                    </x-slot>
                                </x-fab::lists.stacked.grouped-with-actions>
                            </div>
                        @endforeach
                    </x-fab::lists.stacked>
                @else
                    <x-fab::feedback.alert type="info">
                        Please save the parent variant before you can attach products to it.
                    </x-fab::feedback.alert>
                @endif
            </x-fab::layouts.panel>
        </div>

    </x-fab::layouts.main-with-aside>
</x-fab::layouts.page>

@push('styles')
    <link href="{{ asset('vendor/shopify/css/go-load-up.css') }}" rel="stylesheet">
@endpush
