<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAiHoneypotServiceProvider extends PackageServiceProvider
{
    public static string $name = 'laravel-ai-honeypot';

    public static string $viewNamespace = 'laravel-ai-honeypot';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub($this->getRepoName());
            });
    }

    protected function getRepoName(): string
    {
        return 'Voltra/'.static::$name;
    }

    protected function getAssetPackageName(): ?string
    {
        return 'voltra/'.static::$name;
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [];
    }
}
