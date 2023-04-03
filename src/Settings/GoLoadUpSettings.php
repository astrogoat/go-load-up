<?php

namespace Astrogoat\GoLoadUp\Settings;

use Astrogoat\Shopify\Models\Product;
use Helix\Lego\Settings\AppSettings;
use Illuminate\Validation\Rule;

class GoLoadUpSettings extends AppSettings
{
    public string $white_glove_shopify_product_ID;
    public string $CA_removal_only_mattress_shopify_ID;
    public string $removal_only_mattress_shopify_ID;

    public function rules(): array
    {
        return [
             'white_glove_shopify_product_ID' => Rule::requiredIf($this->enabled === true),
             'CA_removal_only_mattress_shopify_ID' => Rule::requiredIf($this->enabled === true),
             'removal_only_mattress_shopify_ID' => Rule::requiredIf($this->enabled === true),
        ];
    }

    public function whiteGloveShopifyProductIdOptions()
    {
        return Product::orderBy('title', 'asc')->get()->pluck('title', 'shopify_id')->toArray();
    }

    public function caRemovalOnlyMattressShopifyIdOptions()
    {
        return Product::where('shopify_id', $this->white_glove_shopify_product_ID)->first()?->variants()->pluck('title', 'shopify_id')->toArray() ?? [];
    }

    public function removalOnlyMattressShopifyIdOptions()
    {
        return Product::where('shopify_id', $this->white_glove_shopify_product_ID)->first()?->variants()->pluck('title', 'shopify_id')->toArray() ?? [];
    }

    public function description(): string
    {
        return 'Interact with GoLoadUp.';
    }

    public static function group(): string
    {
        return 'go-load-up';
    }
}
