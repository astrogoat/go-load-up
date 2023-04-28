<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\Models\Services;

use Astrogoat\GoLoadUp\Enums\ServiceModifier;
use Astrogoat\GoLoadUp\Enums\ServicePart;
use Astrogoat\GoLoadUp\GoLoadUp;
use Astrogoat\GoLoadUp\Models\Service;
use Astrogoat\Shopify\Models\ProductVariant;
use Helix\Fabrick\Notification;
use Helix\Lego\Http\Livewire\Traits\ProvidesFeedback;
use Livewire\Component;

class Index extends Component
{
    use ProvidesFeedback;

    /**
     * This is the list of all available services that we can offer to our
     * customers. Each service is made up of a collection of one (1) or
     * more products from Shopify that make up the selected service.
     */
    public array $possibleCombinations = [
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::ADJUSTABLE_BASE],
            'setup' => [],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'setup' => [],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'setup' => [],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'setup' => [],
            'modifiers' => [],
        ],
        [
            'removal' => [],
            'setup' => [ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'setup' => [ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'setup' => [ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [],
            'setup' => [ServicePart::MATTRESS],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::MATTRESS],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [ServicePart::MATTRESS],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::MATTRESS],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS],
            'modifiers' => [],
        ],
        [
            'removal' => [],
            'setup' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [],
        ],
        [
            'removal' => [],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'modifiers' => [],
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [],
            'modifiers' => [ServiceModifier::CALIFORNIA]
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [ServiceModifier::CALIFORNIA]
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [ServiceModifier::CALIFORNIA]
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [ServicePart::MATTRESS, ServicePart::FOUNDATION],
            'modifiers' => [ServiceModifier::CALIFORNIA]
        ],
        [
            'removal' => [ServicePart::MATTRESS],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'modifiers' => [ServiceModifier::CALIFORNIA]
        ],
        [
            'removal' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE],
            'setup' => [ServicePart::MATTRESS, ServicePart::ADJUSTABLE_BASE, ServicePart::FOUNDATION],
            'modifiers' => [ServiceModifier::CALIFORNIA]
        ],
    ];

    public function mount()
    {
        $services = Service::all();
        $loadUp = resolve(GoLoadUp::class);

        // Hydrate all the possible combinations with generated
        // codes, and any product variants that's been saved
        // in the database from any previous interaction.
        $this->possibleCombinations = collect($this->possibleCombinations)
            ->map(function (array $combination) use ($services, $loadUp) {
                $combination['code'] = $loadUp->generateCodeFromCombination($combination);
                $combination['product_variant_ids'] = $services->where('code', $combination['code'])->first()?->product_variant_ids ?? [];

                return $combination;
            })->toArray();
    }

    public function generateLabelFromCombination(array $combination): string
    {
        $removal = implode('</strong> + <strong>', array_map(function (ServicePart|string $part) {
            return $part instanceof ServicePart ? $part->value : $part;
        }, $combination['removal']));

        $setup = implode('</strong> + <strong>', array_map(function (ServicePart|string $part) {
            return $part instanceof ServicePart ? $part->value : $part;
        }, $combination['setup']));

        $modifierLabels = [];

        foreach ($combination['modifiers'] ?? [] as $modifier) {
            $modifier = $modifier instanceof ServiceModifier ? $modifier : ServiceModifier::from($modifier);
            $modifierLabels[] = $modifier->label();
        }

        $label = '';
        $modifierLabels = implode(', ', $modifierLabels);

        if (! empty($modifierLabels)) {
            $label .= "$modifierLabels<br>";
        }

        $label .= "Removal: <strong>$removal</strong> <br> Setup:&nbsp;&nbsp; <strong>$setup</strong>";

        return $label;
    }

    protected function getWhiteGloveProductVariants(): array
    {
        return resolve(GoLoadUp::class)->getWhiteGloveProduct()?->variants->toArray() ?? [];
    }

    public function getProductVariant($id): ?ProductVariant
    {
        return ProductVariant::find($id);
    }

    public function removeSpecificProductFromPossibleCombinationArray($key, $loopIndex): void
    {
        unset($this->possibleCombinations[$key]['product_variant_ids'][$loopIndex]);
        $this->possibleCombinations[$key]['product_variant_ids'] = array_values($this->possibleCombinations[$key]['product_variant_ids']);
    }

    public function save(): void
    {
        // Drop all old records and replace with new ones
        Service::query()->truncate();

        foreach ($this->possibleCombinations as $combination) {
            Service::query()->create([
                'code' => $combination['code'],
                'product_variant_ids' => $combination['product_variant_ids'],
            ]);
        }

        $this->notify(Notification::success('Saved')->autoDismiss());
    }

    public function render()
    {
        return view('go-load-up::models.services.index')
            ->extends('lego::layouts.lego')
            ->section('content');
    }
}
