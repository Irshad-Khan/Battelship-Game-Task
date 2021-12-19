<?php

namespace App\Providers;

use App\Contracts\GuessInterface;
use App\Repositories\GuessRepository;
use App\Services\GameHistoryService;
use App\Services\ShipService;
use App\Services\UserSerivce;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GuessInterface::class,GuessRepository::class);
        $this->app->bind('shipService',function(){
            return new ShipService();
        });
        $this->app->bind('userService',function(){
            return new UserSerivce();
        });
        $this->app->bind('gameHistoryService',function(){
            return new GameHistoryService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
