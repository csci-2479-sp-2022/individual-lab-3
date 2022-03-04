<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use App\Contracts\PetService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PetController extends Controller
{
    public function __construct(
        private PetService $petService
    ) {

    }

    public function show(?int $id = null)
    {
        if (is_int($id)) {
            return $this->getPetDetails($id);
        }

        return $this->getPetList();
    }

    private function getPetList()
    {
        return view('pet-list', [
            'pets' => $this->petService->getPets(),
        ]);
    }

    private function getPetDetails(int $id)
    {
        $pet = $this->petService->getPetById($id);

        if ($pet == null) {
            throw new NotFoundHttpException();
        }

        return view('pet-details', [
            'pet' => $pet,
        ]);
    }

    private static function getPets()
    {
        return [
            Pet::make([
                'id' => 1,
                'name' => 'Fido',
                'age' => 5,
                'type' => Pet::PET_TYPE_DOG,
            ]),
            Pet::make([
                'id' => 2,
                'name' => 'Milo',
                'age' => 3,
                'type' => Pet::PET_TYPE_CAT,
            ]),
        ];
    }
}
