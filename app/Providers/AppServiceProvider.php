<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Hotel;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Chỉ chia sẻ cho các view cần thiết (hoặc dùng '*' nếu Thịnh muốn chắc chắn)
        View::composer('*', function ($view) {
            // Lấy 12 khách sạn, có thể sắp xếp theo sao (star) giảm dần để hiện hàng xịn lên trước
            // Sửa star thành id để lấy các khách sạn mới nhất
            $header_hotels = Hotel::orderBy('id', 'desc')->take(12)->get();
            
            $view->with('header_hotels', $header_hotels);
        });

        Paginator::useBootstrapFive();
    }
}