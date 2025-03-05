<?php

namespace App\Providers;

use App\Repositories\Contracts\IClubRepository;
use App\Repositories\Contracts\ICompetitionRepository;
use App\Repositories\Contracts\IGameRepository;
use App\Repositories\Contracts\IPerformanceRepository;
use App\Repositories\Contracts\IPlaceRepository;
use App\Repositories\Contracts\IPlayerRepository;
use App\Repositories\Eloquent\ClubRepository;
use App\Repositories\Eloquent\CompetitionRepository;
use App\Repositories\Eloquent\GameRepository;
use App\Repositories\Eloquent\PerformanceRepository;
use App\Repositories\Eloquent\PlaceRepository;
use App\Repositories\Eloquent\PlayerRepository;
use App\Services\ClubService;
use App\Services\CompetitionService;
use App\Services\Contracts\IClubService;
use App\Services\Contracts\ICompetitionService;
use App\Services\Contracts\IGameService;
use App\Services\Contracts\IPerformanceService;
use App\Services\Contracts\IPlaceService;
use App\Services\Contracts\IPlayerService;
use App\Services\GameService;
use App\Services\PerformanceService;
use App\Services\PlaceService;
use App\Services\PlayerService;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

        $this->app->bind(IPlayerRepository::class, PlayerRepository::class);
        $this->app->bind(IPlayerService::class, PlayerService::class);

        $this->app->bind(IGameRepository::class, GameRepository::class);
        $this->app->bind(IGameService::class, GameService::class);

        $this->app->bind(ICompetitionRepository::class, CompetitionRepository::class);
        $this->app->bind(ICompetitionService::class, CompetitionService::class);

        $this->app->bind(IPerformanceRepository::class, PerformanceRepository::class);
        $this->app->bind(IPerformanceService::class, PerformanceService::class);



        // Register the Serializer manually
        $this->app->singleton(Serializer::class, function ($app) {
            $encoders = [new JsonEncoder(), new XmlEncoder()];
            $normalizers = [new ObjectNormalizer()];

            return new Serializer($normalizers, $encoders);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
