<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGiftCodeRequest;
use App\Http\Requests\UpdateGiftCodeRequest;
use App\Services\GiftService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function __construct(private GiftService $giftService)
    {
        /** @var \Illuminate\Routing\Controller $this */
        $this->middleware('can:view giftcodes')->only('index', 'show');
        $this->middleware('can:create giftcodes')->only('create', 'store');
        $this->middleware('can:edit giftcodes')->only('edit', 'update');
    }

    public function index(Request $request): View
    {
        if(!Auth::user()->can('view giftcodes'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $giftCodes = $this->giftService->getAllGiftCode($request);

        return view('admin.giftcodes.index', compact('giftCodes'));
    }

    public function show(int $id)
    {
        if(!Auth::user()->can('view giftcodes'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $giftCode = $this->giftService->getGiftCodeById($id);

        return view('admin.giftcodes.show', compact('giftCode'));
    }
    
    public function create(): View
    {
        if(!Auth::user()->can('create giftcodes'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        return view('admin.giftcodes.create');
    }

    public function store(StoreGiftCodeRequest $request): RedirectResponse
    {
        if(!Auth::user()->can('create giftcodes'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

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
        if(Auth::user()->can('edit giftcodes'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $giftCode = $this->giftService->getGiftCodeById($id);

        return view('admin.giftcodes.edit', compact('giftCode'));
    }

    public function update(int $id, UpdateGiftCodeRequest $request): RedirectResponse
    {
        if(Auth::user()->can('edit giftcodes'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }
        
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
