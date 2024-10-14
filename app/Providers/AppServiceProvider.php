<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Schedule;
use Carbon\Carbon;

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
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        Schema::defaultStringLength(191);

        $categories = Category::get();
        view()->share('categories', $categories);

        $info = Setting::first();
        view()->share('info', $info);

        $total_notification = Schedule::whereDate('date', Carbon::today())->count();
        view()->share('total_notification', $total_notification);

        $notifications = Schedule::whereDate('date', Carbon::today())->paginate(3);
        view()->share('notifications', $notifications);
    }
}
