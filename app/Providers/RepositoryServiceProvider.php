<?php

namespace App\Providers;

use App\BookInterface;
use App\CategoryInterface;
use App\RackInterface;
use App\RecordInterface;
use App\repositories\BookRepository;
use App\repositories\CategoryRepository;
use App\repositories\RackRepository;
use App\repositories\RecordRepository;
use App\repositories\UserRepository;
use App\UserInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(RackInterface::class, RackRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(BookInterface::class, BookRepository::class);
        $this->app->bind(RecordInterface::class, RecordRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
