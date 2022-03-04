<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
phpinfo();
class Pet extends Model
{
    use HasFactory;

    public const PET_TYPE_DOG = 'dog';
    public const PET_TYPE_CAT = 'cat';

    protected $fillable = [
        'id',
        'name',
        'age',
        'type',
    ];

    public function toString(): string
    {
        return "name: $this->name, age: $this->age, type: $this->type";
    }
}
