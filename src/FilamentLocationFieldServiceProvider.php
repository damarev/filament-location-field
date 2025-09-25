<?php

namespace Damarev\FilamentLocationField;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Damarev\FilamentLocationField\Commands\FilamentLocationFieldCommand;
use Damarev\FilamentLocationField\Testing\TestsFilamentLocationField;

class FilamentLocationFieldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-location-field';

    public static string $viewNamespace = 'filament-location-field';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile();
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        // Testing
        Testable::mixin(new TestsFilamentLocationField);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'damarev/filament-location-field';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // Js::make('scripts', __DIR__ . '/../resources/dist/scripts.js'),
            Css::make('styles', __DIR__ . '/../resources/dist/styles.css')->loadedOnRequest(),
            AlpineComponent::make('location-form-field', __DIR__ . '/../resources/dist/location-form-field.js'),
            AlpineComponent::make('location-infolist-entry', __DIR__ . '/../resources/dist/location-infolist-entry.js'),
        ];
    }
}
