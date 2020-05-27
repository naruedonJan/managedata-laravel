<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event){
            $event->menu->add('ระบบจัดการของรางวัล');
            $event->menu->add(
                
                [
                    'text' => 'จัดการหมวดหมู่ของรางวัล',
                    'url'  => 'admin/category',
                    'icon' => 'fas fa-fw fa-gifts',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'จัดการของรางวัล',
                    'url'  => 'admin/reward_setting',
                    'icon' => 'fas fa-fw fa-gifts',
                    'icon_color' => 'yellow',
                ],
                [
                    'text' => 'บันทึกการแลกของรางวัล',
                    'url'  => 'admin/rewardGet',
                    'icon' => 'fas fa-fw fa-clipboard',
                    'icon_color' => 'green',
                ],
            );
            $event->menu->add('ระบบจัดการผู้ใช้');
            $event->menu->add(
                
                [
                    'text' => 'จัดการผู้ใช้',
                    'url'  => 'admin/user',
                    'icon' => 'fas fa-fw fa-user',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'จัดการ agent',
                    'url'  => 'admin/agent',
                    'icon' => 'fas fa-fw fa-users',
                    'icon_color' => 'green',
                ],
            );
            $event->menu->add('ระบบจัดการเกมส์');
            $event->menu->add(
                
                [
                    'text' => 'เกมส์กล่องสุ่ม',
                    'url'  => 'admin/luckybox_setting',
                    'icon' => 'fas fa-fw fa-dice-d6',
                    'icon_color' => 'red',
                ],
                [

                    'text' => 'เกมส์วงล้อนำโชค',
                    'url'  => 'admin/spinner_setting',
                    'icon' => 'fas fa-fw fa-dharmachakra',
                    'icon_color' => 'blue',
                ],
            );
        });
    }
}
