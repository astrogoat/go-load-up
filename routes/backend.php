<?php
use Astrogoat\GoLoadUp\Http\Controllers\GoLoadUpController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'go-load-up.',
    'prefix' => 'go-load-up/'
], function () {
    Route::get('/', [GoLoadUpController::class, 'index'])->name('index');

    Route::group([
        'as' => 'zip-codes.',
        'prefix' => 'zip-codes/'
    ], function () {
        Route::get('/{zipCode}/edit', [GoLoadUpController::class, 'edit'])->name('edit');
        Route::get('/upload', \Astrogoat\GoLoadUp\Http\Livewire\Upload\CsvUploadForm::class)->name('upload');
    });
});

