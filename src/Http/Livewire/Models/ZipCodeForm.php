<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\Models;

use Helix\Lego\Http\Livewire\Models\Form;

class ZipCodeForm extends Form
{
    protected bool $canBeViewed = false;

    public function rules()
    {
        return [
            'model.zip' => 'required',
            'model.name' => 'required',
            'model.is_california' => 'required',
            'model.is_serviceable' => 'required',
            'model.is_eligible' => 'required',
        ];
    }

    public function mount($zipCode)
    {
        $this->setModel($zipCode);
    }

    public function saved()
    {
        if ($this->model->wasRecentlyCreated) {
            return redirect()->to(route('lego.go-load-up.zipcodes.edit', $this->model));
        }
    }

    public function view()
    {
        return 'go-load-up::models.zip-codes.form';
    }
}
