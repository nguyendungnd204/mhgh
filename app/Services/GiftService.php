<?php

namespace App\Services;

use App\Repositories\GiftRepository;
use Illuminate\Http\Request;

class GiftService
{
    public function __construct(private GiftRepository $giftRepository){}

    public function getAllGiftCode(Request $request)
    {
        $query = $this->giftRepository->getQuerywithRelations(['users']);

        if($request->filled('search'))
        {
            $query = $this->giftRepository->search($query, $request->search);
        }

        return $query->paginate(15);
    }

    public function getGiftCodeById(int $id)
    {
        $giftCode = $this->giftRepository->findWithRelations($id);

        return $giftCode;
    }


}