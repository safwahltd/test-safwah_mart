<?php

namespace Module\Permission\database\seeds;


use Illuminate\Database\Seeder;
use Module\Permission\Models\PermissionFeature;

class PermissionFeatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = ['Order Type', 'Company', 'Department', 'Designation', 'Buyer', 'Branches', 'Factories'];

        foreach ($features as $key => $feature) {

            PermissionFeature::firstOrCreate([
                'name' => $feature
            ]);
        }
    }
}
