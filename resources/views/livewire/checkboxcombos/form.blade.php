<x-fab::layouts.page
    :title="'Cart Checkbox Combinations'"
    :breadcrumbs="[
            ['title' => 'Home', 'url' => route('lego.dashboard')],
        ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')"  For Mac
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')"  For PC
>
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
            <div>
                <button wire:click="save">Save Combination Data</button>
                @foreach($possibleCombinations as $key => $products)
                    <div class="grid grid-cols-2 gap-4 py-4">
                        <div>
                            <div class="text-xs text-gray-500 ">{{ $possibleCombinations[$key]['label'] }}</div>
                        </div>
                        <div class="flex flex-col">
                            <select wire:change="readyToSave" class="text-sm" wire:model="possibleCombinations.{{ $key }}.products.{{ count($products['products']) }}">
                                <option> Select product </option>
                                @foreach($this->getProductsForCollectionCombobox() as $item)
                                    <option value="{{ $item['key'] }}">{{ $item['value'] }}</option>
                                @endforeach
                            </select>

                            <div>
                                @foreach($products['products'] as $product)
                                    <div class="flex justify-between">
                                        <div class="grow text-gray-500 text-xs pt-2">{{ $this->getProduct($possibleCombinations[$key]['products'][$loop->index])?->title }}</div>
                                        <button class="text-gray-500" wire:click="removeSpecificProductFromPossibleCombinationArray({{$key}}, {{$loop->index}})">x</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <ul>

                    </ul>
                @endforeach
            </div>
        </x-fab::layouts.panel>

    </x-fab::layouts.main-with-aside>
</x-fab::layouts.page>

@push('styles')
    <link href="{{ asset('vendor/shopify/css/go-load-up.css') }}" rel="stylesheet">
@endpush
