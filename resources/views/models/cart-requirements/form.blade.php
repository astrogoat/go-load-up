<x-fab::layouts.page
    :title="$model?->title ?: 'Untitled'"
    description="In order for a customer to check out with this services, the following requirements must be met in the cart"
    :breadcrumbs="[
        ['title' => 'Go Load Up'],
        ['title' => 'Cart requirements', 'url' => route('lego.go-load-up.cart-requirements.index')],
        ['title' => $model?->title ?: 'Untitled'],
    ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')"
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')"
>
    <x-slot name="actions">
        @include('lego::models._includes.forms.page-actions')
    </x-slot>

    <x-lego::feedback.errors class="mb-4" />

    <x-fab::layouts.main-with-aside>
        <x-fab::layouts.panel>
            @unless($this->model->exists)
                <x-fab::forms.select
                    wire:model="model.service_product_variant_id"
                    label="Service"
                    help="Choose the service for which you want to set requirements"
                >
                    <option value="">-- Select GoLoadUp Product Variant --</option>
                    @foreach($this->getWhiteGloveProductVariants() as $variant)
                        <option value="{{ $variant->id }}">{{ $variant->title }}</option>
                    @endforeach
                </x-fab::forms.select>
            @endunless

            <x-fab::forms.input
                label="Error Message"
                wire:model="model.error_message"
                help="Displays when a product is missing from one of the lists below."
            />
        </x-fab::layouts.panel>

        <div class="flex gap-4">
            <x-fab::layouts.panel
                title="Required items in cart"
                description="At least one (1) of the following products must be present in the customers cart in order to checkout with this service."
                class="mt-4 flex-1"
                allow-overflow
                x-on:fab-added="$wire.call('selectProduct', $event.detail[1].key, 1)"
                x-on:fab-removed="$wire.call('removeSelectedProduct', $event.detail[1].key, 1)"
            >
                <x-fab::forms.combobox
                    componentKey="requiredProductsSet1"
                    :items="$this->getProductsForComboBox(1)"
                ></x-fab::forms.combobox>

                <x-fab::lists.stacked>
                    @foreach($this->model->productRequirementsFromSet(1) as $product)
                        <div x-sortable.products.item="{{ $product->id }}">
                            <x-fab::lists.stacked.grouped-with-actions
                                :title="$product->title"
                                :description="$product->type"
                            >
                                <x-slot name="actions">
                                    <x-fab::elements.button
                                        size="xs"
                                        type="link"
                                        :url="route('lego.products.edit', $product->id)"
                                    >
                                        View
                                    </x-fab::elements.button>

                                    <x-fab::elements.button
                                        size="xs"
                                        wire:click="removeSelectedProduct({{ $product->id }}, 1)"
                                    >
                                        Remove
                                    </x-fab::elements.button>
                                </x-slot>
                            </x-fab::lists.stacked.grouped-with-actions>
                        </div>
                    @endforeach
                </x-fab::lists.stacked>
            </x-fab::layouts.panel>

            <div class="flex items-center">
                <span class="p-2 bg-gray-200 rounded-lg text-xs uppercase font-bold">and</span>
            </div>

            <x-fab::layouts.panel
                title="Required items in cart"
                description="At least one (1) of the left side's requirements must be present in the cart AND at least one (1) of the following products must be present in the customers cart in order to checkout with this service. Leave blank if no requirements."
                class="mt-4 flex-1"
                allow-overflow
                x-on:fab-added="$wire.call('selectProduct', $event.detail[1].key, 2)"
                x-on:fab-removed="$wire.call('removeSelectedProduct', $event.detail[1].key, 2)"
            >
                <x-fab::forms.combobox
                    componentKey="requiredProductsSet2"
                    :items="$this->getProductsForComboBox(2)"
                ></x-fab::forms.combobox>

                <x-fab::lists.stacked>
                    @foreach($this->model->productRequirementsFromSet(2) as $product)
                        <div x-sortable.products.item="{{ $product->id }}">
                            <x-fab::lists.stacked.grouped-with-actions
                                :title="$product->title"
                                :description="$product->type"
                            >
                                <x-slot name="actions">
                                    <x-fab::elements.button
                                        size="xs"
                                        type="link"
                                        :url="route('lego.products.edit', $product->id)"
                                    >
                                        View
                                    </x-fab::elements.button>

                                    <x-fab::elements.button
                                        size="xs"
                                        wire:click="removeSelectedProduct({{ $product->id }}, 2)"
                                    >
                                        Remove
                                    </x-fab::elements.button>
                                </x-slot>
                            </x-fab::lists.stacked.grouped-with-actions>
                        </div>
                    @endforeach
                </x-fab::lists.stacked>
            </x-fab::layouts.panel>
        </div>
    </x-fab::layouts.main-with-aside>
</x-fab::layouts.page>

@push('styles')
    <link href="{{ asset('vendor/shopify/css/go-load-up.css') }}" rel="stylesheet">
@endpush
