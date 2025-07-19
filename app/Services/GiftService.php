<?php

namespace App\Services;

use App\Models\GiftCode;
use App\Repositories\GiftRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftService
{
    public function __construct(private GiftRepository $giftRepository) {}

    public function getAllGiftCode(Request $request)
    {
        $query = $this->giftRepository->getQuerywithRelations(['creator']);

        if ($request->filled('search')) {
            $query = $this->giftRepository->search($query, $request->search);
        }
        $query = $query->latest();

        return $query->paginate(15);
    }

    public function getGiftCodeById(int $id, array $relations = []): ?GiftCode
    {
        return $this->giftRepository->findWithRelations($id, $relations);
    }


    public function deactivateExpiredGiftCodes(): void
    {
        $giftCodes = $this->giftRepository->getAll();

        foreach ($giftCodes as $giftCode) {
            if ($giftCode->isExpired() && $giftCode->is_active) {
                $giftCode->update(['is_active' => false]);
            }
        }
    }

    public function generateUniqueCode(int $length = 8): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        
        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while (GiftCode::where('code', $code)->exists()); 
        
        return $code;
    }

    public function generateGiftCode(int $length = 10): string
    {
        return $this->generateUniqueCode($length);
    }

    public function createGiftCode(array $data): GiftCode
    {
        $data['code'] = $this->generateGiftCode(rand(10, 12));
        
        $data['created_by'] = Auth::id();
        return $this->giftRepository->create($data);
    }

    public function updateGiftCode(GiftCode $giftCode, array $data): GiftCode
    {
        $data['created_by'] = Auth::id();
        return $this->giftRepository->update($giftCode, $data);
    }

    public function count(): int
    {
        return $this->giftRepository->count();
    }

}
