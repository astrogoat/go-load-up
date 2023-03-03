<?php

namespace Astrogoat\GoLoadUp;

use Astrogoat\GoLoadUp\Http\Livewire\Models\GoLoadUpProductVariantForm;
use Astrogoat\GoLoadUp\Http\Livewire\Models\ZipCodeForm;
use Astrogoat\GoLoadUp\Http\Livewire\Upload\CsvUploadForm;
use Astrogoat\GoLoadUp\Models\ZipCode;
use Astrogoat\GoLoadUp\Settings\GoLoadUpSettings;
use Helix\Fabrick\Icon;
use Helix\Lego\Apps\App;
use Helix\Lego\LegoManager;
use Helix\Lego\Menus\Lego\Group;
use Helix\Lego\Menus\Lego\Link;
use Helix\Lego\Menus\Menu;
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
                            Link::to(route('lego.go-load-up.product-match.index'), 'Product Match'),
                            Link::to(route('lego.go-load-up.zip-codes.index'), 'Zip Codes'),
                        ],
                        Icon::BOOK_OPEN,
                    )->after('Pages'),
                );
            })
            ->backendRoutes(__DIR__.'/../routes/backend.php')
            ->frontendRoutes(__DIR__.'/../routes/frontend.php');
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

        Livewire::component('astrogoat.go-load-up.zip-codes.form', ZipCodeForm::class);
        Livewire::component('astrogoat.go-load-up.product.form', GoLoadUpProductVariantForm::class);
        Livewire::component('astrogoat.go-load-up.upload.form', CsvUploadForm::class);
    }
}
