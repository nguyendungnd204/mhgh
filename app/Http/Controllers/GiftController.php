<?php

namespace App\Http\Controllers;

use App\Services\GiftService;
use Illuminate\View\View;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function __construct(private GiftService $giftService){}

    public function index(Request $request): View
    {
        $giftCodes = $this->giftService->getAllGiftCode($request);

        return view('admin.giftCode.index', compact('giftCodes'));
    }

    public function show(int $id)
    {
        $giftCode = $this->giftService->getGiftCodeById($id);

        return view('admin.giftcode.show', compact('giftCode'));
    }
    
}
