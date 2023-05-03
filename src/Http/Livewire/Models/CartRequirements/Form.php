<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\Models\CartRequirements;

use Astrogoat\GoLoadUp\GoLoadUp;
use Astrogoat\GoLoadUp\Models\CartRequirement;
use Astrogoat\Shopify\Models\Product;
use Astrogoat\Shopify\Models\ProductVariant;
use Helix\Lego\Http\Livewire\Models\Form as BaseForm;

class Form extends BaseForm
{
    protected bool $canBeViewed = false;
    protected bool $canBeReplicated = false;

    public function mount($cartRequirement = null): void
    {
        $this->setModel($cartRequirement);
    }

    public function rules(): array
    {
        return [
            'model.service_product_variant_id' => ['required', 'int'],
            'model.error_message' => ['required', 'string'],
            'model.first_set_of_required_shopify_product_ids' => ['nullable', 'array'],
            'model.second_set_of_required_shopify_product_ids' => ['nullable', 'array'],
        ];
    }

    public function model(): string
    {
        return CartRequirement::class;
    }

    public function getWhiteGloveProductVariants()
    {
        return resolve(GoLoadUp::class)
            ->getWhiteGloveProduct()
            ?->variants
            ->reject(function (ProductVariant $variant) {
                return CartRequirement::query()->where('service_product_variant_id', $variant->id)->exists();
            }) ?? [];
    }

    public function getProductsForComboBox(int $set): array
    {
        $selection = match ($set) {
            1 => $this->model->first_set_of_required_shopify_product_ids,
            2 => $this->model->second_set_of_required_shopify_product_ids,
        };

        return Product::all()->map(fn (Product $product) => [
            'key' => $product->id,
            'value' => $product->title,
            'selected' => in_array($product->id, $selection ?? []),
        ])->toArray();
    }

    public function selectProduct(int $productId, int $set): void
    {
        if ($set === 1) {
            $ids = $this->model->first_set_of_required_shopify_product_ids;
            $ids[] = $productId;
            $this->model->first_set_of_required_shopify_product_ids = $ids;

        } elseif ($set === 2) {
            $ids = $this->model->second_set_of_required_shopify_product_ids;
            $ids[] = $productId;
            $this->model->second_set_of_required_shopify_product_ids = $ids;
        }

        $this->markAsDirty();
    }

    public function removeSelectedProduct(int $productId, int $set): void
    {
        if ($set === 1) {
            $ids = collect($this->model->first_set_of_required_shopify_product_ids)
                ->reject(fn ($id) => $id === $productId)->toArray();

            $this->model->first_set_of_required_shopify_product_ids = $ids;
            $this->emitTo('fab.forms.combobox', 'updateItems', $this->getProductsForComboBox(1));
        } elseif ($set === 2) {
            $ids = collect($this->model->second_set_of_required_shopify_product_ids)
                ->reject(fn ($id) => $id === $productId)->toArray();

            $this->model->second_set_of_required_shopify_product_ids = $ids;
            $this->emitTo('fab.forms.combobox', 'updateItems', $this->getProductsForComboBox(2));
        }

        $this->markAsDirty();
    }

    public function view(): string
    {
        return 'go-load-up::models.cart-requirements.form';
    }
}
