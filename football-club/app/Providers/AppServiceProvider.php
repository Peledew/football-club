<?php

namespace App\Providers;

use App\Repositories\Contracts\IClubRepository;
use App\Repositories\Contracts\IPlaceRepository;
use App\Repositories\Eloquent\ClubRepository;
use App\Repositories\Eloquent\PlaceRepository;
use App\Services\ClubService;
use App\Services\Contracts\IClubService;
use App\Services\Contracts\IPlaceService;
use App\Services\PlaceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IPlaceRepository::class, PlaceRepository::class);
        $this->app->bind(IPlaceService::class, PlaceService::class);

        $this->app->bind(IClubRepository::class, ClubRepository::class);
        $this->app->bind(IClubService::class, ClubService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
