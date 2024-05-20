<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->colors([
                'primary' => Color::Sky,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Customer & Supplier')
                    ->icon('heroicon-o-building-storefront'), // Group icon
                    NavigationGroup::make()
                        ->label('Transaction Order')
                        ->icon('heroicon-o-shopping-cart'), // Group icon
                        NavigationGroup::make()
                            ->label('Finance management')
                            ->icon('heroicon-o-clipboard-document-list'), // Group icon
                            NavigationGroup::make()
                                ->label('Company Management')
                                ->icon('heroicon-o-building-office-2'), // Group icon
                NavigationGroup::make()
                    ->label('System management')
                    ->icon('heroicon-o-cog'), // Group icon
            ])
            ->brandName('Merx')
            ->brandLogo('https://res.cloudinary.com/boxity-id/image/upload/v1715936883/MERX/3_lkm2tu.png')
            ->brandLogoHeight('3rem')
            ->favicon('https://res.cloudinary.com/boxity-id/image/upload/v1715936883/MERX/2_utiydq.png')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
