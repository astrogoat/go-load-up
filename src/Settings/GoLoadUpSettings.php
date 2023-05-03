<?php

namespace Astrogoat\GoLoadUp\Settings;

use Astrogoat\Shopify\Models\Product;
use Helix\Lego\Settings\AppSettings;
use Illuminate\Validation\Rule;

class GoLoadUpSettings extends AppSettings
{
    public string $white_glove_shopify_product_id;
    public string $removal_only_mattress_shopify_id;
    public string $california_removal_only_mattress_shopify_id;

    public function rules(): array
    {
        return [
             'white_glove_shopify_product_id' => Rule::requiredIf($this->enabled === true),
             'removal_only_mattress_shopify_id' => Rule::requiredIf($this->enabled === true),
             'california_removal_only_mattress_shopify_id' => Rule::requiredIf($this->enabled === true),
        ];
    }

    public function whiteGloveShopifyProductIdOptions()
    {
        return Product::orderBy('title', 'asc')->get()->pluck('title', 'shopify_id')->toArray();
    }

    public function californiaRemovalOnlyMattressShopifyIdOptions()
    {
        return Product::where('shopify_id', $this->white_glove_shopify_product_id)->first()?->variants()->pluck('title', 'shopify_id')->toArray() ?? [];
    }

    public function removalOnlyMattressShopifyIdOptions()
    {
        return Product::where('shopify_id', $this->white_glove_shopify_product_id)->first()?->variants()->pluck('title', 'shopify_id')->toArray() ?? [];
    }

    public function labels(): array
    {
        return [
            'white_glove_shopify_product_id' => 'White Glove product',
            'california_removal_only_mattress_shopify_id' => 'Mattress only removal product variant for California',
            'removal_only_mattress_shopify_id' => 'Mattress only removal only product variant',
        ];
    }

    public function help(): array
    {
        return [
            'california_removal_only_mattress_shopify_id' => 'Select the White Glove product above first.',
            'removal_only_mattress_shopify_id' => 'Select the White Glove product above first.',
        ];
    }

    public function description(): string
    {
        return 'Junk removal. The modern way.';
    }

    public static function group(): string
    {
        return 'go-load-up';
    }
}
