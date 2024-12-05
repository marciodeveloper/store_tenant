<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // \App\Models\Tenant::factory(10)
        //     ->hasStores(1)
        //     ->create();
        // \App\Models\Store::withoutGlobalScope(\App\Scopes\TenantScope::class)->get() as $store

        foreach(\App\Models\Store::all() as $store) {

            $tenantAndStoreIds = ['store_id' => $store->id, 'tenant_id' => $store->tenant_id];

            \App\Models\Product::factory(20, $tenantAndStoreIds)
                ->create();
        }
    }
}
