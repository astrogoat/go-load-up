<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\CheckboxCombos;

use Astrogoat\GoLoadUp\Models\CheckboxCombination;
use Astrogoat\GoLoadUp\Settings\GoLoadUpSettings;
use Astrogoat\Shopify\Models\Product;
use Astrogoat\Shopify\Models\ProductVariant;
use Illuminate\Support\Collection as SupportCollection;
use Livewire\Component;

class CheckboxCombos extends Component
{
    public SupportCollection $selectedProducts;
    public array $selectedProductsIds = [];

    /*  This is the initial data,
        would be replaced with the edited version
        from admin and subsequently fetch from db.
    */
    public array $possibleCombinations = [
        '1' => [
            'code' => '1',
            'label' => 'Removal - Mattress',
            'products' => [],
        ],
        '2' => [
            'code' => '2',
            'label' => 'Removal - Adj Base',
            'products' => [],
        ],
        '3' => [
            'code' => '13',
            'label' => 'Removal - Mattress + Removal - Foundation',
            'products' => [],
        ],
        '4' => [
            'code' => '12',
            'label' => 'Removal - Mattress + Removal - Adj Base',
            'products' => [],
        ],
        '5' => [
            'code' => '123',
            'label' => 'Removal - Mattress + Removal - Adj Base + Removal - Foundation',
            'products' => [],
        ],
        '6' => [
            'code' => '5',
            'label' => 'Setup - Adj Base',
            'products' => [],
        ],
        '7' => [
            'code' => '25',
            'label' => 'Setup - Adj Base + Removal - Adj Base',
            'products' => [],
        ],
        '8' => [
            'code' => '15',
            'label' => 'Setup - Adj Base + Removal - Mattress',
            'products' => [],
        ],
        '9' => [
            'code' => '135',
            'label' => 'Setup - Adj Base + Removal - Mattress + Removal - Foundation',
            'products' => [],
        ],
        '10' => [
            'code' => '125',
            'label' => 'Setup - Adj Base + Removal - Mattress + Removal - Adj Base',
            'products' => [],
        ],
        '11' => [
            'code' => '1235',
            'label' => 'Setup - Adj Base + Removal - Mattress + Removal - Adj Base + Removal - Foundation',
            'products' => [],
        ],
        '12' => [
            'code' => '4',
            'label' => 'Setup - Mattress',
            'products' => [],
        ],
        '13' => [
            'code' => '24',
            'label' => 'Setup - Mattress + Removal - Adj Base',
            'products' => [],
        ],
        '14' => [
            'code' => '14',
            'label' => 'Setup - Mattress + Removal - Mattress',
            'products' => [],
        ],
        '15' => [
            'code' => '134',
            'label' => 'Setup - Mattress + Removal - Mattress + Removal - Foundation',
            'products' => [],
        ],
        '16' => [
            'code' => '124',
            'label' => 'Setup - Mattress + Removal - Mattress + Removal - Adj Base',
            'products' => [],
        ],
        '17' => [
            'code' => '1234',
            'label' => 'Setup - Mattress + Removal - Mattress + Removal - Adj Base + Removal - Foundation',
            'products' => [],
        ],
        '18' => [
            'code' => '46',
            'label' => 'Setup - Mattress + Setup - Foundation',
            'products' => [],
        ],
        '19' => [
            'code' => '246',
            'label' => 'Setup - Mattress + Setup - Foundation + Removal - Adj Base',
            'products' => [],
        ],
        '20' => [
            'code' => '146',
            'label' => 'Setup - Mattress + Setup - Foundation + Removal - Mattress',
            'products' => [],
        ],
        '21' => [
            'code' => '1346',
            'label' => 'Setup - Mattress + Setup - Foundation + Removal - Mattress + Removal - Foundation',
            'products' => [],
        ],
        '22' => [
            'code' => '1246',
            'label' => 'Setup - Mattress + Setup - Foundation + Removal - Mattress + Removal - Adj Base',
            'products' => [],
        ],
        '23' => [
            'code' => '12346',
            'label' => 'Setup - Mattress + Setup - Foundation + Removal - Mattress + Removal - Adj Base + Removal - Foundation',
            'products' => [],
        ],
        '24' => [
            'code' => '45',
            'label' => 'Setup - Mattress + Setup - Adj Base',
            'products' => [],
        ],
        '25' => [
            'code' => '245',
            'label' => 'Setup - Mattress + Setup - Adj Base + Removal - Adj Base',
            'products' => [],
        ],
        '26' => [
            'code' => '145',
            'label' => 'Setup - Mattress + Setup - Adj Base + Removal - Mattress',
            'products' => [],
        ],
        '27' => [
            'code' => '1345',
            'label' => 'Setup - Mattress + Setup - Adj Base + Removal - Mattress + Removal - Foundation',
            'products' => [],
        ],
        '28' => [
            'code' => '1245',
            'label' => 'Setup - Mattress + Removal - Mattress + Removal - Adj Base + Removal - Foundation',
            'products' => [],
        ],
        '29' => [
            'code' => '12345',
            'label' => 'Setup - Mattress + Setup - Adj Base + Removal - Mattress + Removal - Adj Base + Removal - Foundation',
            'products' => [],
        ],
        '30' => [
            'code' => '456',
            'label' => 'Setup - Mattress + Setup - Adj Base + Setup - Foundation',
            'products' => [],
        ],
        '31' => [
            'code' => '2456',
            'label' => 'Setup - Mattress + Setup - Adj Base + Setup - Foundation + Removal - Adj Base',
            'products' => [],
        ],
        '32' => [
            'code' => '1456',
            'label' => 'Setup - Mattress + Setup - Adj Base + Setup - Foundation + Removal - Mattress',
            'products' => [],
        ],
        '33' => [
            'code' => '13456',
            'label' => 'Setup - Mattress + Setup - Adj Base + Setup - Foundation + Removal - Mattress + Removal - Foundation',
            'products' => [],
        ],
        '34' => [
            'code' => '12456',
            'label' => 'Setup - Mattress + Setup - Adj Base + Setup - Foundation + Removal - Mattress + Removal - Adj Base',
            'products' => [],
        ],
        '35' => [
            'code' => '123456',
            'label' => 'Setup - Mattress + Setup - Adj Base + Setup - Foundation + Removal - Mattress + Removal - Adj Base + Removal - Foundation',
            'products' => [],
        ],
        '36' => [
            'code' => '10',
            'label' => 'CA Removal - Mattress',
            'products' => [],
        ],
        '37' => [
            'code' => '1250',
            'label' => 'CA Setup - Adj Base + Removal - Mattress + Removal - Adj Base',
            'products' => [],
        ],
        '38' => [
            'code' => '150',
            'label' => 'CA Setup - Adj Base + Removal - Mattress',
            'products' => [],
        ],
        '39' => [
            'code' => '1460',
            'label' => 'CA Setup - Mattress + Setup - Foundation + Removal - Mattress',
            'products' => [],
        ],
        '40' => [
            'code' => '1450',
            'label' => 'CA Setup - Mattress + Setup - Adj Base + Removal - Mattress',
            'products' => [],
        ],
        '41' => [
            'code' => '1234560',
            'label' => 'CA Setup - Mattress + Setup - Adj Base + Setup - Foundation + Removal - Mattress + Removal - Adj Base',
            'products' => [],
        ],
    ];

    public function mount()
    {
        $this->selectedProducts = collect([]);
        $combinationsFromDB = CheckboxCombination::all();

        // Replace initial data if configurations already exists in the db.
        if($combinationsFromDB->isNotEmpty()) {
            $decodedJsonData = $combinationsFromDB->map(function ($item) {
                $item = [
                    'code' => $item->code,
                    'label' => $item->label,
                    'products' => json_decode($item->products),
                ];

                return $item;
            });
            $this->possibleCombinations = $decodedJsonData->toArray();
        }
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
        return Product::where('shopify_id', settings(GoLoadUpSettings::class, 'white_glove_shopify_product_id'))?->first()->variants->map(fn (ProductVariant $product) => [
            'key' => $product->shopify_id,
            'value' => $product->title,
            'selected' => false,
        ])->toArray();

    }

    public function getProduct($shopifyId)
    {
        return ProductVariant::where('shopify_id', $shopifyId)?->first();
    }

    public function removeSpecificProductFromPossibleCombinationArray($key, $loopIndex)
    {
        unset($this->possibleCombinations[$key]['products'][$loopIndex]);
        $this->possibleCombinations[$key]['products'] = array_values($this->possibleCombinations[$key]['products']);
    }

    public function selectProduct($productId, $option)
    {
        $this->selectedProductsIds[] = $productId;
        $this->selectedProducts->push(Product::find($productId));
    }

    public function save()
    {
        // drop all old records and replace with new ones
        CheckboxCombination::truncate();

        foreach ($this->possibleCombinations as $item) {
            CheckboxCombination::create([
                'code' => $item['code'],
                'label' => $item['label'],
                'products' => json_encode($item['products']),
            ]);
        }


    }
}
