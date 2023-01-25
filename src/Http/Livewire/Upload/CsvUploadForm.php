<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\Upload;

use Astrogoat\GoLoadUp\Jobs\ProcessUploadZipCodes;
use Helix\Lego\Notifications\BellNotification;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use mysql_xdevapi\Exception;
use Spatie\SimpleExcel\SimpleExcelReader;
use Tonning\Flash\Flash;

class CsvUploadForm extends Component
{
    use WithFileUploads;
    public $file;

    public function mount()
    {
        if (! File::exists(storage_path('framework/cache'))) {
            File::makeDirectory(path: storage_path('framework/cache'), recursive: true);
        }
    }

    public function rules()
    {
        return [];
    }

    public function render()
    {
        return view('go-load-up::livewire.upload.form')->extends('lego::layouts.lego')->section('content');
    }

    public function uploadData()
    {
        try {
            if (!is_null($this->file)) {
                $zipcode_chunks = SimpleExcelReader::create($this->file->getRealPath(), 'csv')
                    ->getRows()->chunk(300)->all();

                Flash::success('Zip Codes are Importing...');

                foreach ($zipcode_chunks as $index => $chunkData) {
                    ProcessUploadZipCodes::dispatch(zipcodes: $chunkData, isLastBatch: count($zipcode_chunks) == $index + 1);
                }
            } else {
                return back()->with('error', 'No file selected');
            }

        } catch (Exception $exception) {
            auth()->user()->notify(new BellNotification(
                title: 'Zip codes import failed!',
                message: 'Failed to import zip codes from csv. Error: ' . $exception->getMessage(),
            ));
        }
    }
}
