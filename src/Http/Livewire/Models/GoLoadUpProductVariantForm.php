<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\Models;

use Astrogoat\GoLoadUp\Models\GoLoadUpProduct;
use Astrogoat\GoLoadUp\Models\GoLoadUpProductRelation;
use Astrogoat\GoLoadUp\Settings\GoLoadUpSettings;
use Astrogoat\Shopify\Models\Product;
use Helix\Lego\Http\Livewire\Models\Form;
use Illuminate\Support\Collection as SupportCollection;

class GoLoadUpProductVariantForm extends Form
{
    public SupportCollection $selectedOptionsOne;
    public array $selectedOptionsOneIds = [];

    public SupportCollection $selectedOptionsTwo;
    public array $selectedOptionsTwoIds = [];

    protected $listeners = [
        'updateProductsOrder',
    ];

    public function rules()
    {
        return [
            'model.parent_product_variant_id' => 'required',
            'model.error_message' => 'nullable',
        ];
    }

    public function mount($goLoadUpProduct = null)
    {
        $this->setModel($goLoadUpProduct);

        $this->setErrorLabel();

        $this->selectedOptionsOne = $this->model->products->reject(function ($product) {
            return $product->pivot->product_option != 1;
        });

        $this->selectedOptionsOneIds = $this->selectedOptionsOne->map(fn ($product) => $product->id)->toArray();

        $this->selectedOptionsTwo = $this->model->products->reject(function ($product) {
            return $product->pivot->product_option != 2;
        });

        $this->selectedOptionsTwoIds = $this->selectedOptionsTwo->map(fn ($product) => $product->id)->toArray();
    }

    public function setErrorLabel()
    {
        $variants = $this->getVariantsOfDefaultProduct();

        $variant = $variants->reject(function ($item) {
            return $item->id != $this->model->parent_product_variant_id;
        });

        if ($variant->isNotEmpty()) {
            if (is_null($this->model->error_message)) {
                $this->model->error_message = 'Oh no! You have added "' . $variant->first()->title . '" to your cart, but';
            }
        }
    }

    public function saving()
    {
        $this->insertRecords($this->selectedOptionsOne, 1);
        $this->insertRecords($this->selectedOptionsTwo, 2);

        $this->deleteRecords($this->selectedOptionsOne, 1);
        $this->deleteRecords($this->selectedOptionsTwo, 2);
    }

    public function insertRecords(SupportCollection $selectedOptions, int $productOption)
    {
        foreach ($selectedOptions as $key => $product) {
            $existingRelations = $this->model->products->reject(function ($product) use ($productOption) {
                return $product->pivot->product_option != $productOption;
            });

            $currentMatchFromDB = $existingRelations
                ->reject(function ($itemFromDB) use ($product) {
                    return $itemFromDB->pivot->product_id != $product->id;
                })
                ->reject(function ($itemFromDB) use ($product, $productOption) {
                    return $itemFromDB->pivot->product_option != $productOption;
                });

            if ($currentMatchFromDB->isEmpty()) {
                GoLoadUpProductRelation::create(
                    [
                        'go_load_up_product_id' => $this->model->id,
                        'product_id' => $product->id,
                        'product_option' => $productOption,
                        'order' => $key,
                    ]
                );
            }
        }
    }

    public function deleteRecords(SupportCollection $selectedOptions, int $productOption)
    {
        $existingRelations = $this->model->products->reject(function ($product) use ($productOption) {
            return $product->pivot->product_option != $productOption;
        });

        foreach ($existingRelations as $key => $product) {
            $matchFromSelectedOptions = $selectedOptions
                ->reject(function ($item) use ($productOption, $product) {
                    return $product->pivot->product_id != $item->id;
                });

            if ($matchFromSelectedOptions->isEmpty()) {
                $record = GoLoadUpProductRelation::find($product->pivot->id);
                $record->delete();
            }
        }
    }

    public function updated($property, $value)
    {
        parent::updated($property, $value);
    }

    protected function getProductsForCollectionCombobox1(): array
    {
        return Product::all()->map(fn (Product $product) => [
            'key' => $product->id,
            'value' => $product->title,
            'selected' => in_array($product->id, $this->selectedOptionsOneIds),
        ])->toArray();
    }

    protected function getProductsForCollectionCombobox2(): array
    {
        return Product::all()->map(fn (Product $product) => [
            'key' => $product->id,
            'value' => $product->title,
            'selected' => in_array($product->id, $this->selectedOptionsTwoIds),
        ])->toArray();
    }

    public function getVariantsOfDefaultProduct()
    {
        $defaultProduct = Product::where('shopify_id', settings(GoLoadUpSettings::class, 'white_glove_shopify_product_ID'))?->first();
        if (! ($defaultProduct == null)) {
            return $defaultProduct->variants;
        }

        return collect([]);
    }

    public function selectProduct($productId, $option)
    {
        if ($option == 1) {
            $this->selectedOptionsOneIds[] = $productId;
            $this->selectedOptionsOne->push(Product::find($productId));
        } elseif ($option == 2) {
            $this->selectedOptionsTwoIds[] = $productId;
            $this->selectedOptionsTwo->push(Product::find($productId));
        }
        $this->markAsDirty();
    }

    public function unselectProduct($productId, $option)
    {
        if ($option == 1) {
            $this->selectedOptionsOneIds = array_filter($this->selectedOptionsOneIds, fn ($id) => $id !== $productId);
            $this->selectedOptionsOne = $this->selectedOptionsOne->reject(fn ($product) => $product->id === $productId);
            $this->emitTo('fab.forms.combobox', 'updateItems', $this->getProductsForCollectionCombobox1());
        } elseif ($option == 2) {
            $this->selectedOptionsTwoIds = array_filter($this->selectedOptionsTwoIds, fn ($id) => $id !== $productId);
            $this->selectedOptionsTwo = $this->selectedOptionsTwo->reject(fn ($product) => $product->id === $productId);
            $this->emitTo('fab.forms.combobox', 'updateItems', $this->getProductsForCollectionCombobox2());
        }

        $this->markAsDirty();
    }

    public function updateProductsOrder($order)
    {
        $this->selectedOptionsOne = $this->selectedOptionsOne
            ->sort(function ($a, $b) use ($order) {
                $positionA = array_search($a->id, $order);
                $positionB = array_search($b->id, $order);

                return $positionA - $positionB;
            })
            ->values();

        $this->markAsDirty();
    }

    public function view()
    {
        return 'go-load-up::models.product-variants.form';
    }

    public function model(): string
    {
        return GoLoadUpProduct::class;
    }
}
