<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PetService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PetController extends Controller
{
    public function __construct(
        private PetService $petService
    ) {  }

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
}
