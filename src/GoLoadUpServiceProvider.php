<?php

namespace Astrogoat\GoLoadUp;

use Astrogoat\Blog\Http\Livewire\Models\ArticleForm;
use Astrogoat\GoLoadUp\Http\Livewire\Models\ZipCodeForm;
use Astrogoat\GoLoadUp\Http\Livewire\Upload\CsvUploadForm;
use Astrogoat\GoLoadUp\Models\ZipCode;
use Helix\Fabrick\Icon;
use Helix\Lego\Apps\App;
use Helix\Lego\LegoManager;
use Helix\Lego\Menus\Lego\Link;
use Helix\Lego\Menus\Menu;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Astrogoat\GoLoadUp\Settings\GoLoadUpSettings;

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
                ZipCode::class
            ])
            ->menu(function (Menu $menu) {
                $menu->addToSection(
                    Menu::MAIN_SECTIONS['PRIMARY'],
                    Link::to(route('lego.go-load-up.index'), 'GoLoadUp')
                        ->after('Pages')
                        ->icon(Icon::BOOK_OPEN)
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
        Livewire::component('astrogoat.go-load-up.upload.form', CsvUploadForm::class);

    }
}
