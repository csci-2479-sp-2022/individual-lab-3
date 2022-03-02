<?php

namespace App\Services;

use App\Contracts\PetService;
use App\Models\Pet;

class InMemoryPetService implements PetService
{
    public function getPets(): array
    {
        return [
            Pet::make([
                'id' => 1,
                'name' => 'Salem',
                'age' => 9,
                'type' => Pet::PET_TYPE_DOG,
            ]),
            Pet::make([
                'id' => 2,
                'name' => 'Albus',
                'age' => 2,
                'type' => Pet::PET_TYPE_CAT,
            ]),
        ];
    }

    public function getPetsSingle(): array
    {
        return [
            Pet::make([
                'id' => 1,
                'name' => 'Salem',
                'age' => 9,
                'type' => Pet::PET_TYPE_DOG,
            ]),
            Pet::make([
                'id' => 2,
                'name' => 'Albus',
                'age' => 2,
                'type' => Pet::PET_TYPE_CAT,
            ]),
        ];
    }

    public function getPetById(int $id): ?Pet
    {
        foreach ($this->getPets() as $pet) {
            if ($pet->id === $id) {
                return $pet;
            }
        }

        return null;
    }
}
