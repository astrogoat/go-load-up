<?php

namespace Astrogoat\GoLoadUp\Http\Controllers;

use Astrogoat\GoLoadUp\GoLoadUp;
use Astrogoat\GoLoadUp\Settings\GoLoadUpSettings;
use Astrogoat\Shopify\Models\ProductVariant;
use Illuminate\Http\Request;

class GoLoadUpApiController
{
    public function checkEligibility(Request $request)
    {
        $wgLineItems = $request->wg_line_items;
        $zipCode = $request->zip;

        $validZipCode = resolve(GoLoadUp::class)->getZipCodeModel($zipCode);

        if(is_null($validZipCode)) {
            return response()->json([
                    'status' => 404,
                    'error_message' => "Not in service area.",
                ]);
        }

        if ($validZipCode->is_california) {
            $shopifyId = $this->getRemovalOnlyMattress(false)?->shopify_id;
        } else {
            $shopifyId = $this->getRemovalOnlyMattress(true)?->shopify_id;
        }

        if(in_array($shopifyId, $wgLineItems)) {
            return response()->json([
                'status' => 406,
                'wg_line_item' => $shopifyId,
                'error_message' => "OMR and Zip mismatch",
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => "All good!",
        ]);

    }

    public function getRemovalOnlyMattress($isCA = false)
    {
        $key = $isCA ? "california_removal_only_mattress_shopify_id" : "removal_only_mattress_shopify_id";

        return ProductVariant::where('shopify_id', settings(GoLoadUpSettings::class, $key))?->first();
    }
}
