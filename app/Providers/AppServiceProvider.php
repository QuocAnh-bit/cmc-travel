<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Hotel; // Import Model Hotel
use Illuminate\Pagination\Paginator; // Thêm dòng này

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Chia sẻ biến $all_hotels cho tất cả các view
        View::composer('*', function ($view) {
            $view->with('header_hotels', Hotel::all());
        });
        Paginator::useBootstrapFive();
    }
}