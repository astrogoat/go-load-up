<?php

namespace Astrogoat\GoLoadUp;

use Astrogoat\Cart\CartItem;
use Astrogoat\GoLoadUp\Enums\ServiceModifier;
use Astrogoat\GoLoadUp\Enums\ServicePart;
use Astrogoat\GoLoadUp\Enums\ServiceType;
use Astrogoat\GoLoadUp\Exceptions\IneligibleWhiteGloveItemsFoundInCart;
use Astrogoat\GoLoadUp\Models\CartRequirement;
use Astrogoat\GoLoadUp\Models\ZipCode;
use Astrogoat\GoLoadUp\Settings\GoLoadUpSettings;
use Astrogoat\Shopify\Models\Product;
use Illuminate\Support\Collection;
use Throwable;

class GoLoadUp
{
    public function getWhiteGloveProduct(): ?Product
    {
        return Product::query()
            ->where('shopify_id', resolve(GoLoadUpSettings::class)->white_glove_shopify_product_id)
            ->first();
    }

    public function getZipCodeModel($zipCode): ZipCode|null
    {
        return ZipCode::all()->where('zip', $zipCode)->first();
    }

    public function generateCodeFromCombination(array $combination): string
    {
        $code = [];

        foreach ($combination['removal'] as $removalPart) {
            $removalPart = $removalPart instanceof ServicePart ? $removalPart : ServicePart::from($removalPart);
            $code[] = $removalPart->code(ServiceType::REMOVAL);
        }

        foreach ($combination['setup'] as $setupPart) {
            $setupPart = $setupPart instanceof ServicePart ? $setupPart : ServicePart::from($setupPart);
            $code[] = $setupPart->code(ServiceType::SETUP);
        }

        sort($code); // Sort the codes in descending order.

        // Add any modifiers/flags to the code.
        foreach ($combination['modifiers'] ?? [] as $modifier) {
            $modifier = $modifier instanceof ServiceModifier ? $modifier : ServiceModifier::from($modifier);
            $code[] = $modifier->code();
        }

        return implode('', $code); // Generate the string for of the code.
    }

    public function getWhiteGloveProductVariantsInCart() : Collection
    {
        $whiteGloveProduct = Product::query()
            ->where('shopify_id', resolve(GoLoadUpSettings::class)->white_glove_shopify_product_id)
            ->first();

        return cart()->getItems()->filter(function (CartItem $cartItem) use ($whiteGloveProduct) {
            return $cartItem->getProduct()?->shopify_id == $whiteGloveProduct?->shopify_id;
        });
    }

    public function getNonWhiteGloveProductVariantsInCart() : Collection
    {
        $whiteGloveProduct = Product::query()
            ->where('shopify_id', resolve(GoLoadUpSettings::class)->white_glove_shopify_product_id)
            ->first();

        return cart()->getItems()->reject(function (CartItem $cartItem) use ($whiteGloveProduct) {
            return $cartItem->getProduct()?->shopify_id == $whiteGloveProduct?->shopify_id;
        });
    }

    /**
     * @throws IneligibleWhiteGloveItemsFoundInCart
     * @throws Throwable
     */
    public function validateCartRequirement(): void
    {
        /** @var CartItem $cartItem */
        foreach ($this->getWhiteGloveProductVariantsInCart() as $cartItem) {
            $variant = $cartItem->findModel();

            if (! $variant) {
                continue;
            }

            $requirement = CartRequirement::findByShopifyProductVariant($variant);

            throw_unless(
                $requirement?->isEligible() ?? true, // If requirement not found, we assume it is eligible.
                IneligibleWhiteGloveItemsFoundInCart::class,
                $requirement?->errorMessage()
            );
        };
    }
}
