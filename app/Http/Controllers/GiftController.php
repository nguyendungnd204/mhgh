<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGiftCodeRequest;
use App\Http\Requests\UpdateGiftCodeRequest;
use App\Services\GiftService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function __construct(private GiftService $giftService){}

     public function index(Request $request): View
    {
        $giftCodes = $this->giftService->getAllGiftCode($request);

        return view('admin.giftcodes.index', compact('giftCodes'));
    }

    public function show(int $id)
    {
        $giftCode = $this->giftService->getGiftCodeById($id);

        return view('admin.giftcodes.show', compact('giftCode'));
    }
    
    public function create(): View
    {
        return view('admin.giftcodes.create');
    }

    public function store(StoreGiftCodeRequest $request): RedirectResponse
    {
        try {
            $this->giftService->createGiftCode($request->validated());
            
            return redirect()->route('admin.giftcodes.index')
                           ->with('success', 'Tạo mã quà tặng thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi khi tạo: ' . $e->getMessage());
        }
    }

    //   public function generateCode(): JsonResponse
    // {
    //     try {
    //         $code = $this->giftService->generateGiftCode();
    //         return response()->json(['code' => $code]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Có lỗi khi tạo mã'], 500);
    //     }
    // }

    public function edit(int $id): View
    {
        $giftCode = $this->giftService->getGiftCodeById($id);

        return view('admin.giftcodes.edit', compact('giftCode'));
    }

    public function update(int $id, UpdateGiftCodeRequest $request): RedirectResponse
    {
        try {
            $giftCode = $this->giftService->getGiftCodeById($id, ['creator']);
            $this->giftService->updateGiftCode($giftCode, $request->validated());

        //      dd([
        //     'giftCode' => $giftCode,
        //     'validated_data' => $request->validated(),
        //     'all_input' => $request->all()
        // ]);
            return redirect()->route('admin.giftcodes.index')
                           ->with('success', 'Cập nhật mã quà tặng thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi khi cập nhật: ' . $e->getMessage());
        }
    }
}
