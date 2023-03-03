<?php

namespace Astrogoat\GoLoadUp\Models;

use Astrogoat\Shopify\Models\Product;
use Astrogoat\Shopify\Models\ProductVariant;
use Helix\Fabrick\Icon;
use Helix\Lego\Models\Model as LegoModel;

class GoLoadUpProduct extends LegoModel
{
    protected $table = 'go_load_up_product';

    public static function icon(): string
    {
        return Icon::DOCUMENT;
    }

    public function getDisplayKeyName()
    {
        return 'title';
    }

    public function parentProduct()
    {
        return $this->belongsTo(ProductVariant::class, 'parent_product_variant_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'go_load_up_shopify_product', )
            ->withPivot('id')
            ->withPivot('product_option')
            ->withPivot('order')
            ->orderBy('order');
    }
}
