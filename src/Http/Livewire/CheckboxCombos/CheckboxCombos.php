<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\CheckboxCombos;

use Astrogoat\GoLoadUp\Settings\GoLoadUpSettings;
use Astrogoat\Shopify\Models\Product;
use Astrogoat\Shopify\Models\ProductVariant;
use Illuminate\Support\Collection as SupportCollection;
use Livewire\Component;

class CheckboxCombos extends Component
{
    public SupportCollection $selectedProducts;
    public array $selectedProductsIds = [];

    public array $possibleCombinations = [
        [
            'code' => '1',
            'label' => 'Removal - Mattress',
        ],
        [
            'code' => '2',
            'label' => 'Removal - Adj Base',
        ],
        [
            'code' => '13',
            'label' => 'Removal - Mattress + Removal - Foundation',
        ],
        [
            'code' => '12',
            'label' => 'Removal - Mattress + Removal - Adj Base',
        ],
        [
            'code' => '123',
            'label' => 'Removal - Mattress + Removal - Adj Base + Removal - Foundation',
        ],
        [
            'code' => '5',
            'label' => 'Setup - Adj Base',
        ],
        [
            'code' => '25',
            'label' => 'Setup - Adj Base + Removal - Adj Base',
        ],
        [
            'code' => '15',
            'label' => 'Setup - Adj Base + Removal - Mattress',
        ],
        [
            'code' => '135',
            'label' => 'Setup - Adj Base + Removal - Mattress + Removal - Foundation',
        ],
        [
            'code' => '125',
            'label' => 'Setup - Adj Base + Removal - Mattress + Removal - Adj Base',
        ],
        [
            'code' => '1235',
            'label' => 'Setup - Adj Base + Removal - Mattress + Removal - Adj Base + Removal - Foundation',
        ],
        [
            'code' => '4',
            'label' => 'Setup - Mattress',
        ],
        [
            'code' => '24',
            'label' => 'Setup - Mattress + Removal - Adj Base',
        ],
        [
            'code' => '14',
            'label' => 'Setup - Mattress + Removal - Mattress',
        ],
        [
            'code' => '134',
            'label' => 'Setup - Mattress + Removal - Mattress + Removal - Foundation',
        ],
        [
            'code' => '124',
            'label' => 'Setup - Mattress + Removal - Mattress + Removal - Adj Base',
        ],
        [
            'code' => '1234',
            'label' => 'Setup - Mattress + Removal - Mattress + Removal - Adj Base + Removal - Foundation',
        ],
    ];

    public function mount()
    {
        $this->selectedProducts = collect([]);
    }

    public function rules()
    {
        return [];
    }

    public function render()
    {
        return view('go-load-up::livewire.checkboxcombos.form')->extends('lego::layouts.lego')->section('content');
    }

    protected function getProductsForCollectionCombobox(): array
    {
        //        dd(Product::where('shopify_id', settings(GoLoadUpSettings::class, 'white_glove_shopify_product_ID'))?->first()->variants);
        return Product::where('shopify_id', settings(GoLoadUpSettings::class, 'white_glove_shopify_product_ID'))?->first()->variants->map(fn (ProductVariant $product) => [
            'key' => $product->id,
            'value' => $product->title,
//            'selected' => in_array($product->id, $this->selectedOptionsOneIds),
            'selected' => false,
        ])->toArray();

    }

    public function selectProduct($productId, $option)
    {
        $this->selectedProductsIds[] = $productId;
        $this->selectedProducts->push(Product::find($productId));
        //        $this->markAsDirty();
    }
}
