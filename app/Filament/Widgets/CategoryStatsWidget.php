<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CategoryStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalCategories = Category::count();
        $activeCategories = Category::where('is_active', true)->count();
        $totalProducts = Product::count();
        $avgProductsPerCategory = $totalCategories > 0 ? round($totalProducts / $totalCategories, 1) : 0;

        return [
            Stat::make('Total Kategori', $totalCategories)
                ->description('Semua kategori')
                ->descriptionIcon('heroicon-m-tag')
                ->color('amber'),

            Stat::make('Kategori Aktif', $activeCategories)
                ->description('Kategori yang ditampilkan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Produk', $totalProducts)
                ->description('Di semua kategori')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('amber'),

            Stat::make('Rata-rata Produk', $avgProductsPerCategory)
                ->description('Per kategori')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}