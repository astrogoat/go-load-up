<?php

namespace Astrogoat\GoLoadUp\Http\Controllers;

use Astrogoat\GoLoadUp\Models\GoLoadUpProduct;

class GoLoadUpController
{
    public function defaultProductOptions()
    {
        $productVariants = GoLoadUpProduct::paginate(10);

        return view('go-load-up::models.product-variants.index', compact('productVariants'));
    }

    public function createGoLoadUpProduct()
    {
        return view('go-load-up::models.product-variants.create');
    }

    public function editGoLoadUpProduct(GoLoadUpProduct $goLoadUpProduct)
    {
        return view('go-load-up::models.product-variants.edit', compact('goLoadUpProduct'));
    }

    public function checkBoxCombos()
    {
        return view('go-load-up::models.checkbox-combos.index', );
    }
}
