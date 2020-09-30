<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $rolesAndPermissions = [
            'admin' => array_merge(
                $this->bookingServicePermissions(),
                $this->discountServicePermissions(),
                $this->repotingServicePermissions()
            ),
            'user' => array_merge(
                collect($this->bookingServicePermissions())->filter(function($permission) {
                    return $permission !== 'manage-others-bookings';
                })->toArray()
            )
        ];

        foreach ($rolesAndPermissions as $role => $permissions) {
            $role = Role::updateOrCreate(['name' => $role]);

            foreach($permissions as $permission) {
                $permission = Permission::updateOrCreate(['name' => $permission]);

                $role->givePermissionTo($permission);
            }
        }

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
