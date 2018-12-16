<?php

use App\Model\Client;
use App\Model\Contact;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Client::class, 13)->create();
        factory(Contact::class, 20)->create();
    }
}
