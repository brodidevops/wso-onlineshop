<?php

namespace App\View\Composers;

use App\Helpers\StoreHelper;
use Illuminate\View\View;

class StoreSettingsComposer
{
    public function compose(View $view): void
    {
        $view->with('storeSettings', [
            'store_name' => StoreHelper::storeName(),
            'store_tagline' => StoreHelper::storeTagline(),
            'store_email' => StoreHelper::storeEmail(),
            'store_phone' => StoreHelper::storePhone(),
            'store_address' => StoreHelper::storeAddress(),
            'logo_header' => StoreHelper::logoHeaderUrl(),
            'logo_footer' => StoreHelper::logoFooterUrl(),
            'favicon' => StoreHelper::faviconUrl(),
            'primary_color' => StoreHelper::primaryColor(),
            'social_media' => StoreHelper::socialMedia(),
        ]);
    }
}