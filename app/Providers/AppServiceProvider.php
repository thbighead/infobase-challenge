<?php

namespace App\Providers;

use Auth;
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
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add(__('adminlte.main_navigation'));
            $event->menu->add([
                'text' => __('adminlte.users'),
                'url' => route('users.index'),
                'icon' => 'users',
            ]);
            $event->menu->add(__('adminlte.account_configuration'));
            $event->menu->add([
                'text' => __('adminlte.profile'),
                'url' => route('users.show', Auth::id()),
                'icon' => 'user',
            ]);
            $event->menu->add([
                'text' => __('adminlte.change_password'),
                'url' => route('users.edit', Auth::id()),
                'icon' => 'lock',
            ]);
            if (Auth::user()->hasRole('ADMINISTRADOR')) {
                $event->menu->add(__('adminlte.admin_area'));
                $event->menu->add([
                    'text' => 'Telescope',
                    'url' => 'telescope',
                    'icon' => 'bullseye',
                ]);
            }
        });
    }
}
