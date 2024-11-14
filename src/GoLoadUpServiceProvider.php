<?php

namespace Astrogoat\GoLoadUp;

use Astrogoat\Cart\Events\CheckingOut;
use Astrogoat\GoLoadUp\Http\Livewire\Models\CartRequirements;
use Astrogoat\GoLoadUp\Http\Livewire\Models\Services;
use Astrogoat\GoLoadUp\Http\Livewire\Models\ZipCodes\Form;
use Astrogoat\GoLoadUp\Http\Livewire\Models\ZipCodes\Index;
use Astrogoat\GoLoadUp\Http\Livewire\Upload\CsvUploadForm;
use Astrogoat\GoLoadUp\Models\ZipCode;
use Astrogoat\GoLoadUp\Settings\GoLoadUpSettings;
use Helix\Fabrick\Icon;
use Helix\Lego\Apps\App;
use Helix\Lego\LegoManager;
use Helix\Lego\Menus\Lego\Group;
use Helix\Lego\Menus\Lego\Link;
use Helix\Lego\Menus\Menu;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GoLoadUpServiceProvider extends PackageServiceProvider
{
    public function registerApp(App $app)
    {
        return $app
            ->name('go-load-up')
            ->settings(GoLoadUpSettings::class)
            ->migrations([
                __DIR__ . '/../database/migrations',
                __DIR__ . '/../database/migrations/settings',
            ])
            ->models([
                ZipCode::class,
            ])
            ->menu(function (Menu $menu) {
                $menu->addToSection(
                    Menu::MAIN_SECTIONS['PRIMARY'],
                    Group::add(
                        'GoLoadUp',
                        [
                            Link::to(route('lego.go-load-up.services.index'), 'Services'),
                            Link::to(route('lego.go-load-up.zip-codes.index'), 'Zip codes'),
                            Link::to(route('lego.go-load-up.cart-requirements.index'), 'Cart requirements'),
                        ],
                        Icon::TRUCK,
                    )->after('Pages'),
                );
            })
            ->backendRoutes(__DIR__.'/../routes/backend.php')
            ->frontendRoutes(__DIR__.'/../routes/frontend.php')
            ->apiRoutes(__DIR__.'/../routes/api.php');
    }

    public function registeringPackage()
    {
        $this->callAfterResolving('lego', function (LegoManager $lego) {
            $lego->registerApp(fn (App $app) => $this->registerApp($app));
        });
    }

    public function configurePackage(Package $package): void
    {
        $package->name('go-load-up')->hasConfigFile()->hasViews();
    }

    public function bootingPackage()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../public' => public_path('vendor/go-load-up'),
            ], 'go-load-up-assets');
        }

        Event::listen(CheckingOut::class, function (CheckingOut $event) {
            if (GoLoadUpSettings::isEnabled()) {
                resolve(GoLoadUp::class)->validateCartRequirement();
            }
        });

        Livewire::component('astrogoat.go-load-up.http.livewire.models.zip-codes.form', Form::class);
        Livewire::component('astrogoat.go-load-up.http.livewire.models.zip-codes.form', Index::class);
        Livewire::component('astrogoat.go-load-up.http.livewire.models.services.index', Services\Index::class);
        Livewire::component('astrogoat.go-load-up.http.livewire.models.cart-requirements.index', CartRequirements\Index::class);
        Livewire::component('astrogoat.go-load-up.http.livewire.models.cart-requirements.form', CartRequirements\Form::class);
        Livewire::component('astrogoat.go-load-up.upload.form', CsvUploadForm::class);
    }
}
