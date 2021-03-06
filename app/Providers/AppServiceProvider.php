<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Add helper for migration foreign keys.
        \Illuminate\Database\Schema\Blueprint::macro('foreignId', function (
            string $column,
            string $referencedTable,
            string $referencedColumn = 'id',
            bool $nullable = false
        ) {
            $this->unsignedInteger($column)->nullable($nullable);
            $this->foreign($column)->references($referencedColumn)->on($referencedTable);
        });
        \Illuminate\Database\Schema\Blueprint::macro('foreignUuid', function (
            string $column,
            string $referencedTable,
            string $referencedColumn = 'id',
            bool $nullable = false
        ) {
            $this->uuid($column)->nullable($nullable);
            $this->foreign($column)->references($referencedColumn)->on($referencedTable);
        });
        \Illuminate\Database\Schema\Blueprint::macro('morphsUuid', function (
            string $name,
            string $indexName = null,
            bool $nullable = false
        ) {
            $this->string("{$name}_type")->nullable($nullable);

            $this->uuid("{$name}_id")->nullable($nullable);

            $this->index(["{$name}_type", "{$name}_id"], $indexName);
        });

        // Custom morph map.
        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'users' => \App\Models\User::class,
            'service_users' => \App\Models\ServiceUser::class,
        ]);
    }
}
