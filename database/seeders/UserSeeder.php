<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\Ticket;
use App\Models\TicketTime;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $store = Store::updateOrCreate([
            'name' => 'Sakıp Sabancı Mardin Kent Müzesi',
        ]);

        $ticket = Ticket::updateOrCreate([
            'store_id' => $store->id,
            'name' => 'Tam Bilet',
            'slug' => 'tam-bilet',
        ]);

        TicketTime::updateOrCreate([
            'ticket_id' => $ticket->id,
            'name' => '09:00',
            'time' => '09:00',
            'quantity' => 10,
            'price' => 67.5,
        ]);

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'is_admin' => true,
            ],
            [
                'name' => 'Demo',
                'email' => 'demo@demo.com',
                'password' => Hash::make('demo'),
                'is_admin' => false,
            ]
        ];

        foreach ($users as $user)
        {
            $createdUser = User::updateOrCreate(
                [
                    'email' => $user['email']
                ],
                $user
            );
            if (! $createdUser->is_admin)
            {
                $store = Store::first();
                $store->users()->syncWithoutDetaching($createdUser->id);
            }
        }
    }
}
