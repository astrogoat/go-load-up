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
            get: fn ($value) => $this->load('serviceProductVariant')->serviceProductVariant?->title,
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


        if (! $firstRequirementsMet) { // check if any exists in nested bundle line items
            $firstRequirementsMet = $this->existsInBundleLineItems($this->first_set_of_required_shopify_product_ids);
        }

        if (empty($this->second_set_of_required_shopify_product_ids)) {
            return $firstRequirementsMet;
        }

        $secondRequirementsMet = $nonWhiteGloveProductVariantsInCart
            ->map(fn (CartItem $item) => $item->getProduct()?->id ?? null)
            ->values()
            ->intersect($this->second_set_of_required_shopify_product_ids)
            ->isNotEmpty();

        if (! $secondRequirementsMet) { // check if any exists in nested bundle line items
            $secondRequirementsMet = $this->existsInBundleLineItems($this->second_set_of_required_shopify_product_ids);
        }

        return $firstRequirementsMet && $secondRequirementsMet;
    }

    public function existsInBundleLineItems(array $requirementIds): bool
    {
        $bundleLineItemsProductVariantIdsInCart = resolve(GoLoadUp::class)->getProductVariantIdsOfBundleLineItemsInCart();

        return $bundleLineItemsProductVariantIdsInCart
            ->intersect($requirementIds)
            ->isNotEmpty();
    }

    /**
     * Quantity of White Glove service product
     * should not be greater than the quantity
     * of the required product.
     *
     * @param CartItem $cartItem
     * @return array
     */
    public function quantityIsEligible(CartItem $cartItem): array
    {
        if (empty($this->first_set_of_required_shopify_product_ids)) {
            return [true, null];
        }

        $nonWhiteGloveProductVariantsInCart = resolve(GoLoadUp::class)->getNonWhiteGloveProductVariantsInCart();

        $firstRequirementsQuantityError = $this->catchQuantityMismatch($cartItem, $nonWhiteGloveProductVariantsInCart, $this->first_set_of_required_shopify_product_ids);

        if (! $firstRequirementsQuantityError[0]) {
            return $firstRequirementsQuantityError;
        }

        if (empty($this->second_set_of_required_shopify_product_ids)) return [true, null];

        $secondRequirementsQuantityError = $this->catchQuantityMismatch($cartItem, $nonWhiteGloveProductVariantsInCart, $this->second_set_of_required_shopify_product_ids);

        if (! $secondRequirementsQuantityError[0]) {
            return $secondRequirementsQuantityError;
        }

        return [true, null];
    }

    public function catchQuantityMismatch(CartItem $wgCartItem, $nonWhiteGloveProductVariantsInCart, $set_of_required_shopify_product_ids): array
    {
        // Find required products that appear at the top level
        $topLevelProductIds = $nonWhiteGloveProductVariantsInCart
            ->map(fn($item) => $item->getProduct()?->id)
            ->values()
            ->intersect($set_of_required_shopify_product_ids);

        $totalRequirementsMetQuantity = 0;

        // get total quantity of required products that appear at the top level
        foreach ($topLevelProductIds as $productId) {
            $cartItem = $nonWhiteGloveProductVariantsInCart->first(fn($item) => $item->getProduct()?->id === $productId);
            $totalRequirementsMetQuantity += ($cartItem->getQuantity() ?? 0);
        }

        // Find required products that appear in bundles
        $bundleProductVariantIds = resolve(GoLoadUp::class)->getProductVariantIdsOfBundleLineItemsInCart();
        $bundleRequirementsMet = $bundleProductVariantIds->intersect($set_of_required_shopify_product_ids);

        // get total quantity of required products that appear in bundles
        foreach ($bundleRequirementsMet as $productId) {
            $occurrenceCount = $this->getRequiredProductOccurrenceCountInBundles($productId);
            $totalRequirementsMetQuantity += $occurrenceCount;
        }

        if ($wgCartItem->getQuantity() > $totalRequirementsMetQuantity) {
            return $this->generateErrorResponse($wgCartItem);
        }

        return [true, null];
    }

    private function generateErrorResponse(CartItem $wgCartItem): array
    {
        $serviceTitle = $wgCartItem?->getVariant()?->title ?? 'service';
        $errorMessage = sprintf(
            'The number of %s services you selected does not match the number of eligible products in your cart. ' .
            'Please double-check the items in your cart to ensure the quantity of %s services matches the number of eligible products.',
            $serviceTitle,
            $serviceTitle
        );

        return [false, $errorMessage];
    }

    public function getRequiredProductOccurrenceCountInBundles($productId): int
    {
        $bundleLineItems = resolve(GoLoadUp::class)->getBundleLineItemsInCart();
        $count = 0;

        foreach ($bundleLineItems as $bundleItem) {
            foreach ($bundleItem->getComponents() as $component) {
                if ($component->findModel()?->product_id === $productId) {
                    $count += $component->getQuantity();
                }
            }
        }

        return $count;
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
