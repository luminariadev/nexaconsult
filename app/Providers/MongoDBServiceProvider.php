<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MongoDB\Client;

class MongoDBServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('mongo', function () {
            return new Client(config('database.connections.mongodb.dsn'));
        });
    }
}
