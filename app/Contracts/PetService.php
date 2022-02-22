<?php

namespace App\Contracts;

use App\Models\Pet;

interface PetService
{
    public function getPets(): array;

    public function getPetById(int $id): ?Pet;
}
