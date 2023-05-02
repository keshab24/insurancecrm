<?php

namespace App\Providers;

use App\Http\ViewComposers\ContactInfoComposer;
use App\Http\ViewComposers\GeneralSettingsComposer;
use App\Http\ViewComposers\SocialLinkComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            [
                'frontend.layouts.header',
                'frontend.layouts.footer',
            ],
            SocialLinkComposer::class
        );

        View::composer(
            [
                'frontend.contact',
            ],
            ContactInfoComposer::class
        );

        View::composer(
            [
                'frontend.*',
            ],
            GeneralSettingsComposer::class
        );


        view()->composer(
            [
                'layouts.backend.sidebar'
            ],
            'App\Http\ViewComposers\Backend\SidebarComposer'
        );

        view()->composer(
            [
                'layouts.backend.breadcrumb'
            ],
            'App\Http\ViewComposers\Backend\BreadcrumbComposer'
        );

        // view()->composer(
        //     [
        //         'frontend.header',
        //         'frontend.container',
        //         'frontend.donateUs'
        //     ],
        //     'App\Http\ViewComposers\HeaderComposer'
        // );

        // view()->composer(
        //     [
        //         'frontend.footer'
        //     ],
        //     'App\Http\ViewComposers\FooterComposer'
        // );

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
