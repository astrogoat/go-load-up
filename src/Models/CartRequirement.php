<?php

namespace Astrogoat\GoLoadUp\Models;

use Astrogoat\Cart\CartItem;
use Astrogoat\GoLoadUp\GoLoadUp;
use Astrogoat\Shopify\Models\Product;
use Astrogoat\Shopify\Models\ProductVariant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartRequirement extends Model
{
    protected $table = 'go_load_up_cart_requirements';

    protected $casts = [
        'first_set_of_required_shopify_product_ids' => 'json',
        'second_set_of_required_shopify_product_ids' => 'json',
    ];

    public function getDisplayKeyName()
    {
        return 'title';
    }

    public function displayName(): string
    {
        return $this->getDisplayKeyName();
    }

    public function getEditRoute()
    {
        return route('lego.go-load-up.cart-requirements.edit', $this);
    }

    /**
     * Get the requirement's service product name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->serviceProductVariant?->title,
        );
    }

    public function serviceProductVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function productRequirementsFromSet(int $set): \Illuminate\Support\Collection
    {
        $ids = match ($set) {
            1 => $this->first_set_of_required_shopify_product_ids,
            2 => $this->second_set_of_required_shopify_product_ids,
        };

        return collect($ids)->map(fn ($id) => Product::find($id))->filter();
    }

    /**
     * At least one (1) of the product variants from the first set
     * AND, at least one (1) from the second set must be preset
     * in the cart, in order for the service to be eligible.
     *
     * @return bool
     */
    public function isEligible(): bool
    {
        if (empty($this->first_set_of_required_shopify_product_ids)) {
            return true;
        }

        $nonWhiteGloveProductVariantsInCart = resolve(GoLoadUp::class)->getNonWhiteGloveProductVariantsInCart();

        $firstRequirementsMet = $nonWhiteGloveProductVariantsInCart
            ->map(fn (CartItem $item) => $item->getProduct()?->id ?? null)
            ->values()
            ->intersect($this->first_set_of_required_shopify_product_ids)
            ->isNotEmpty();

        if (empty($this->second_set_of_required_shopify_product_ids)) {
            return $firstRequirementsMet;
        }

        $secondRequirementsMet = $nonWhiteGloveProductVariantsInCart
            ->map(fn (CartItem $item) => $item->getProduct()?->id ?? null)
            ->values()
            ->intersect($this->second_set_of_required_shopify_product_ids)
            ->isNotEmpty();

        return $firstRequirementsMet && $secondRequirementsMet;
    }

    public function errorMessage(): string
    {
        return $this->error_message;
    }

    public static function findByShopifyProductVariant(ProductVariant $variant): ?CartRequirement
    {
        return CartRequirement::query()->where('service_product_variant_id', $variant->id)->first();
    }
}
