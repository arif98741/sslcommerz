<?php
/**
 * @author: Mahabubul Hasan <codehasan@gmail.com>
 * Date: 8/29/2018
 * Time: 12:58 PM
 */

namespace Xenon\SslCommerz;


use Illuminate\Support\ServiceProvider;

class SslCommerzServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/sslcommerz.php' => config_path('sslcommerz.php'),
            __DIR__ . '/Stubs/SslCommerzController.stub' => app_path('../app/Http/Controllers/SslCommerzController.php'),
        ]);


        /* StubGenerator::from(basename(__DIR__) . '/Stubs/SslCommerzController.stub')
             ->to(app_path('../app/Http/Controllers'))
             ->as('SslCommerzController')
             ->ext('php')
             ->save(); // save the file*/
    }
}
