<?php

namespace Astrogoat\GoLoadUp\Http\Controllers;
use Astrogoat\GoLoadUp\Models\ZipCode;

class GoLoadUpController
{
    public function index()
    {
        $totalZipCodes = ZipCode::count();
        $zipCodes = ZipCode::paginate(10);

        return view('go-load-up::models.zip-codes.index', compact('totalZipCodes', 'zipCodes'));
    }

    public function edit(ZipCode $zipCode)
    {
        return view('go-load-up::models.zip-codes.edit', compact('zipCode'));
    }

}
