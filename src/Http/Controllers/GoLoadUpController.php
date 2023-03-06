<?php

namespace Astrogoat\GoLoadUp\Http\Controllers;

use Astrogoat\GoLoadUp\Models\GoLoadUpProduct;
use Astrogoat\GoLoadUp\Models\ZipCode;

class GoLoadUpController
{
    public function index()
    {
        $totalZipCodes = ZipCode::count();
        $zipCodes = ZipCode::paginate(10);

        return view('go-load-up::models.zip-codes.index', compact('totalZipCodes', 'zipCodes'));
    }

    public function defaultProductOptions()
    {
        $productVariants = GoLoadUpProduct::paginate(10);

        return view('go-load-up::models.product-variants.index', compact('productVariants'));
    }

    public function edit(ZipCode $zipCode)
    {
        return view('go-load-up::models.zip-codes.edit', compact('zipCode'));
    }

    public function createGoLoadUpProduct()
    {
        return view('go-load-up::models.product-variants.create');
    }

    public function editGoLoadUpProduct(GoLoadUpProduct $goLoadUpProduct)
    {
        return view('go-load-up::models.product-variants.edit', compact('goLoadUpProduct'));
    }
}
