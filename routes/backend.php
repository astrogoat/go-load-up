<?php
use Astrogoat\GoLoadUp\Http\Controllers\GoLoadUpController;
use Astrogoat\GoLoadUp\Http\Livewire\Models\CartRequirements;
use Astrogoat\GoLoadUp\Http\Livewire\Models\Services;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'go-load-up.',
    'prefix' => 'go-load-up/'
], function () {
    Route::group([
        'as' => 'zip-codes.',
        'prefix' => 'zip-codes'
    ], function () {
        Route::get('/', [GoLoadUpController::class, 'index'])->name('index');
        Route::get('/{zipCode}/edit', [GoLoadUpController::class, 'edit'])->name('edit');
        Route::get('/upload', \Astrogoat\GoLoadUp\Http\Livewire\Upload\CsvUploadForm::class)->name('upload');
    });

    Route::group([
        'as' => 'cart-requirements.',
        'prefix' => 'cart-requirements'
    ], function () {
        Route::get('/', CartRequirements\Index::class)->name('index');
        Route::get('create', CartRequirements\Form::class)->name('create');
        Route::get('{cartRequirement}/edit', CartRequirements\Form::class)->name('edit');
    });

    Route::group([
        'as' => 'services.',
        'prefix' => 'services'
    ], function () {
        Route::get('/', Services\Index::class)->name('index');
    });
});
