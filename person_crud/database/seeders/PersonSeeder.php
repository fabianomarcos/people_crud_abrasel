<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infra\Persistence\Eloquent\Models\PersonModel;

class PersonSeeder extends Seeder
{
    public function run()
    {
        PersonModel::create(attributes: [
            "name" => "Jon Doe",
            "cpf" => "111.444.777-35",
            "birth_date" => "2000-05-10"
        ]);
    }
}
