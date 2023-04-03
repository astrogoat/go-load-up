<?php

use Astrogoat\GoLoadUp\Http\Controllers\GoLoadUpApiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'go-load-up-api.',
    'prefix' => 'go-load-up/'
], function () {
    Route::post('/check-eligibility', [GoLoadUpApiController::class, 'checkEligibility']);
});
