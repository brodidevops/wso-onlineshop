<?php

namespace App\Helpers;

use App\Models\StoreSetting;
use Illuminate\Support\Facades\Cache;

class StoreHelper
{
    /**
     * Get a store setting value
     */
    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("store_setting_{$key}", function () use ($key, $default) {
            return StoreSetting::get($key, $default);
        });
    }

    /**
     * Get all settings in a group
     */
    public static function getGroup(string $group): array
    {
        return Cache::rememberForever("store_settings_group_{$group}", function () use ($group) {
            return StoreSetting::getGroupValues($group);
        });
    }

    /**
     * Get store name
     */
    public static function storeName(): string
    {
        return self::get('store_name', 'Toko Online');
    }

    /**
     * Get store tagline
     */
    public static function storeTagline(): string
    {
        return self::get('store_tagline', 'Belanja Mudah, Hemat, Terpercaya');
    }

    /**
     * Get store email
     */
    public static function storeEmail(): ?string
    {
        return self::get('store_email');
    }

    /**
     * Get store phone
     */
    public static function storePhone(): ?string
    {
        return self::get('store_phone');
    }

    /**
     * Get store address
     */
    public static function storeAddress(): ?string
    {
        return self::get('store_address');
    }

    /**
     * Get logo header URL
     */
    public static function logoHeaderUrl(): ?string
    {
        $logo = self::get('logo_header');
        return $logo ? asset('storage/' . $logo) : null;
    }

    /**
     * Get logo footer URL
     */
    public static function logoFooterUrl(): ?string
    {
        $logo = self::get('logo_footer');
        return $logo ? asset('storage/' . $logo) : null;
    }

    /**
     * Get favicon URL
     */
    public static function faviconUrl(): ?string
    {
        $favicon = self::get('favicon');
        return $favicon ? asset('storage/' . $favicon) : null;
    }

    /**
     * Get primary color
     */
    public static function primaryColor(): string
    {
        return self::get('primary_color', '#1A1A1A');
    }

    /**
     * Get social media links
     */
    public static function socialMedia(): array
    {
        return [
            'facebook' => self::get('social_facebook'),
            'instagram' => self::get('social_instagram'),
            'twitter' => self::get('social_twitter'),
            'tiktok' => self::get('social_tiktok'),
            'youtube' => self::get('social_youtube'),
        ];
    }

    /**
     * Clear cache for store settings
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }

    /**
     * Update setting and clear cache
     */
    public static function update(string $key, $value): void
    {
        StoreSetting::set($key, $value);
        Cache::forget("store_setting_{$key}");
    }
}