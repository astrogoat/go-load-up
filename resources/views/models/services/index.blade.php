<x-fab::layouts.page
    title="Link services to products"
    description="Link/associate available services to the products needed to carry out those services."
    :breadcrumbs="[
        ['title' => 'Go Load Up'],
        ['title' => 'Services'],
    ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')"  {{-- For Mac --}}
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')"  {{-- For PC --}}
>
    <x-lego::feedback.errors class="mb-4" />

    <x-fab::layouts.panel
        title="Select products needed for each service"
        description="On this page you're able to link/associate all the various combinations of services a customer might be able to select, to the products needed in order to carry out those those services selected by the customer."
        allow-overflow
    >
        <div>
            <div class="grid grid-cols-2 gap-4 py-4 font-bold uppercase">
                <div>Service</div>
                <div>Product Variants</div>
            </div>
            @foreach($possibleCombinations as $key => $combination)
                <div class="grid grid-cols-2 gap-4 py-4">
                    <div style="font-family: monospace" class="text-base">{!! $this->generateLabelFromCombination($combination) !!}</div>
                    <div class="flex flex-col">
                        <div>
                            @foreach($combination['product_variant_ids'] as $variantId)
                                <div class="flex justify-between">
                                    <div class="grow text-gray-800 text-sm py-2">{{ $this->getProductVariant($variantId)?->title }}</div>
                                    <button class="text-gray-500" wire:click="removeSpecificProductFromPossibleCombinationArray({{ $key }}, {{  $loop->index }})">
                                        <x-fab::elements.icon :icon="Helix\Fabrick\Icon::TRASH" class="h-4 w-4" />
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <x-fab::forms.select
                            wire:model="possibleCombinations.{{ $key }}.product_variant_ids.{{ count($combination['product_variant_ids']) }}"
                        >
                            <option>Add product(s)</option>
                            @foreach($this->getWhiteGloveProductVariants() as $variant)
                                <option value="{{ $variant['id'] }}">{{ $variant['title'] }}</option>
                            @endforeach
                        </x-fab::forms.select>
                    </div>
                </div>
                <hr/>
            @endforeach
        </div>

        <x-slot name="footer">
            <x-fab::elements.button wire:click="save">Save</x-fab::elements.button>
        </x-slot>
    </x-fab::layouts.panel>
</x-fab::layouts.page>

@push('styles')
    <link href="{{ asset('vendor/shopify/css/go-load-up.css') }}" rel="stylesheet">
@endpush
