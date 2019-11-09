<?php

namespace App\Providers;

use Auth;
use Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param Dispatcher $events
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        /*
         * fixing migration as https://laravel-news.com/laravel-5-4-key-too-long-error
         */
        Schema::defaultStringLength(191);

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add(__('adminlte.main_navigation'));
            $event->menu->add([
                'text' => __('adminlte.users'),
                'url' => route('user.index'),
                'icon' => 'user',
            ]);
            $event->menu->add(__('adminlte.account_configuration'));
            $event->menu->add([
                'text' => __('adminlte.profile'),
                'url' => route('user.show', Auth::id()),
                'icon' => 'user',
            ]);
            $event->menu->add([
                'text' => __('adminlte.change_password'),
                'url' => route('user.edit', Auth::id()),
                'icon' => 'lock',
            ]);
            if (Auth::user()->hasRole('ADMINISTRADOR')) {
                $event->menu->add(__('adminlte.admin_area'));
                $event->menu->add([
                    'text' => __('adminlte.document_models'),
                    'url' => route('document_model.index'),
                    'icon' => 'file-code-o',
                ]);
                $event->menu->add([
                    'text' => 'Telescope',
                    'url' => 'telescope',
                    'icon' => 'bullseye',
                ]);
            }
        });
    }
}
