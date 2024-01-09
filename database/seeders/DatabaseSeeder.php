<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Listing;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $user=User::factory()->create([
            'name'=>'Mohamad qazafi',
            'email'=>'Qazafi@gmail.com'
         ]);
         Listing::factory(6)->create(
            [ 'user_id'=>$user->id ]
         );
    }
}
