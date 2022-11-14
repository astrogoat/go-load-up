<?php

namespace Astrogoat\GoLoadUp\Jobs;

use Astrogoat\GoLoadUp\Models\ZipCode;
use Helix\Lego\Models\User;
use Helix\Lego\Notifications\BellNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUploadZipCodes implements shouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $zipcodes;
    public bool $isLastBatch;

    public User $user;

    public function __construct($zipcodes, $isLastBatch = false)
    {
        $this->zipcodes = $zipcodes;
        $this->isLastBatch = $isLastBatch;

        $this->user = auth()->user();
    }

    public function handle()
    {
        foreach ($this->zipcodes as $zipcodeData)
        {
            $zipcode = new ZipCode();
            $zipcode->zip = $zipcodeData['zip'];
            $zipcode->name = $zipcodeData['name'];
            $zipcode->elp = $zipcodeData['ELP'];
            $zipcode->status = $zipcodeData['status'] == 'enabled';
            $zipcode->save();
        }

        if($this->isLastBatch) {
            $this->user->notify(new BellNotification(
                title: 'Zip codes imported!',
                message: 'Finished importing all zip codes from csv.',
            ));
        }
    }
}
