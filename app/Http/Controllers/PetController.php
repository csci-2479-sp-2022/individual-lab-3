<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PetService;

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
        return view('pet-details', [
            'pet' => $this->petService->getPetById($id),
        ]);
    }
}
