<?php

namespace Astrogoat\GoLoadUp\Settings;

use Astrogoat\Shopify\Models\Product;
use Helix\Lego\Settings\AppSettings;
use Illuminate\Validation\Rule;

class GoLoadUpSettings extends AppSettings
{
    public string $white_glove_shopify_product_id;
    public string $california_removal_only_mattress_shopify_id;
    public string $removal_only_mattress_shopify_id;

    public function rules(): array
    {
        return [
             'white_glove_shopify_product_id' => Rule::requiredIf($this->enabled === true),
             'california_removal_only_mattress_shopify_id' => Rule::requiredIf($this->enabled === true),
             'removal_only_mattress_shopify_id' => Rule::requiredIf($this->enabled === true),
        ];
    }

    public function whiteGloveShopifyProductIdOptions()
    {
        return Product::orderBy('title', 'asc')->get()->pluck('title', 'shopify_id')->toArray();
    }

    public function caRemovalOnlyMattressShopifyIdOptions()
    {
        return Product::where('shopify_id', $this->white_glove_shopify_product_id)->first()?->variants()->pluck('title', 'shopify_id')->toArray() ?? [];
    }

    public function removalOnlyMattressShopifyIdOptions()
    {
        return Product::where('shopify_id', $this->white_glove_shopify_product_id)->first()?->variants()->pluck('title', 'shopify_id')->toArray() ?? [];
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
