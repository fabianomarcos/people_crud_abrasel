<?php
namespace App\Infra\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class PersonModel extends Model
{
    protected $table = "people";
    protected $fillable = ["name", "cpf", "birth_date"];
    protected $dates = ["birth_date"];
}