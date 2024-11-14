<?php
namespace Astrogoat\GoLoadUp\Http\Livewire\Models\ZipCodes;

use Astrogoat\GoLoadUp\Models\ZipCode;
use Helix\Lego\Http\Livewire\Models\Form as BaseForm;

class Form extends BaseForm
{
    protected bool $canBeViewed = false;

    public function mount($zipCode)
    {
        $this->setModel($zipCode);
    }

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

    public function model(): string
    {
        return ZipCode::class;
    }

    public function saved()
    {
        if ($this->model->wasRecentlyCreated) {
            return redirect()->to(route('lego.go-load-up.zip-codes.edit', $this->model));
        }
    }

    public function view()
    {
        return 'go-load-up::models.zip-codes.form';
    }
}
