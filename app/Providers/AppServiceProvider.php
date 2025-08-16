<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Organization;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Override;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', static function (\Illuminate\View\View $view): void {
            $view->with('currentOrganization', Organization::current());
        });
    }
}
