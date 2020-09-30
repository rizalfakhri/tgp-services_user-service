<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
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
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions(
            array_merge(
                $this->bookingServicePermissions(),
                $this->discountServicePermissions(),
                $this->repotingServicePermissions(),
            )
        );
    }

    /**
     * The Booking Service Permissions.
     *
     * @return array
     */
    protected function bookingServicePermissions() : array {
        return [
            'create-booking',
            'view-booking',
            'update-booking',
            'cancel-booking',
            'delete-booking',
            'manage-others-bookings'
        ];
    }

    /**
     * The Discount Service Permissions.
     *
     * @return array
     */
    protected function discountServicePermissions() : array {
        return [
            'create-discount',
            'view-discount',
            'update-discount',
            'delete-discount'
        ];
    }

    /**
     * The Reporting Service Permissions.
     *
     * @return array
     */
    protected function repotingServicePermissions() : array {
        return [
            'generate-report',
            'view-user-report',
            'download-report',
            'delete-report'
        ];
    }
}
