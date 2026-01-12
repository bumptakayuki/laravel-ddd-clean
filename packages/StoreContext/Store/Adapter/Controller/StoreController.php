<?php
namespace Packages\StoreContext\Store\Adapter\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\StoreContext\Store\UseCase\CreateStore\ICreateStoreUseCase;
use Packages\StoreContext\Store\UseCase\CreateStore\CreateStoreInputData;
use Packages\StoreContext\Store\UseCase\UpdateStore\IUpdateStoreUseCase;
use Packages\StoreContext\Store\UseCase\UpdateStore\UpdateStoreInputData;
use Packages\StoreContext\Store\UseCase\ListStores\IListStoresUseCase;
use Packages\StoreContext\Store\UseCase\ListStores\ListStoresInputData;
use Packages\StoreContext\Store\UseCase\GetStoreDetail\IGetStoreDetailUseCase;
use Packages\StoreContext\Store\UseCase\GetStoreDetail\GetStoreDetailInputData;
use Packages\StoreContext\Store\UseCase\CreateStoreBoxLunch\ICreateStoreBoxLunchUseCase;
use Packages\StoreContext\Store\UseCase\CreateStoreBoxLunch\CreateStoreBoxLunchInputData;
use Packages\StoreContext\Store\UseCase\UpdateStoreBoxLunch\IUpdateStoreBoxLunchUseCase;
use Packages\StoreContext\Store\UseCase\UpdateStoreBoxLunch\UpdateStoreBoxLunchInputData;
use Packages\StoreContext\Store\UseCase\CreateStoreArea\ICreateStoreAreaUseCase;
use Packages\StoreContext\Store\UseCase\CreateStoreArea\CreateStoreAreaInputData;
use Packages\StoreContext\Store\UseCase\UpdateStoreArea\IUpdateStoreAreaUseCase;
use Packages\StoreContext\Store\UseCase\UpdateStoreArea\UpdateStoreAreaInputData;

class StoreController extends Controller
{
    public function __construct(
        private readonly ICreateStoreUseCase $createStoreUseCase,
        private readonly IUpdateStoreUseCase $updateStoreUseCase,
        private readonly IListStoresUseCase $listStoresUseCase,
        private readonly IGetStoreDetailUseCase $getStoreDetailUseCase,
        private readonly ICreateStoreBoxLunchUseCase $createStoreBoxLunchUseCase,
        private readonly IUpdateStoreBoxLunchUseCase $updateStoreBoxLunchUseCase,
        private readonly ICreateStoreAreaUseCase $createStoreAreaUseCase,
        private readonly IUpdateStoreAreaUseCase $updateStoreAreaUseCase
    ) {}
    
    /**
     * 店舗一覧を取得する
     */
    public function index()
    {
        $input = new ListStoresInputData();
        $output = $this->listStoresUseCase->handle($input);
        
        return response()->json($output->stores);
    }
    
    /**
     * 店舗詳細を取得する
     */
    public function show(string $storeId)
    {
        $input = new GetStoreDetailInputData($storeId);
        $output = $this->getStoreDetailUseCase->handle($input);
        
        return response()->json($output->store);
    }
    
    /**
     * 店舗を作成する
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:200',
            'is_open' => 'nullable|boolean',
        ]);
        
        $input = new CreateStoreInputData(
            $request->input('name'),
            $request->input('address'),
            $request->input('is_open', true)
        );
        
        $output = $this->createStoreUseCase->handle($input);
        
        return response()->json([
            'store_id' => $output->storeId,
            'message' => $output->message,
        ], 201);
    }
    
    /**
     * 店舗を更新する
     */
    public function update(Request $request, string $storeId)
    {
        $request->validate([
            'name' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:200',
            'is_open' => 'nullable|boolean',
        ]);
        
        $input = new UpdateStoreInputData(
            $storeId,
            $request->input('name'),
            $request->input('address'),
            $request->input('is_open')
        );
        
        $output = $this->updateStoreUseCase->handle($input);
        
        return response()->json([
            'message' => $output->message,
        ]);
    }
    
    /**
     * 店舗の弁当提供情報を作成する
     */
    public function createStoreBoxLunch(Request $request, string $storeId)
    {
        $request->validate([
            'box_lunch_id' => 'required|string',
            'is_available' => 'nullable|boolean',
        ]);
        
        $input = new CreateStoreBoxLunchInputData(
            $storeId,
            $request->input('box_lunch_id'),
            $request->input('is_available', true)
        );
        
        $output = $this->createStoreBoxLunchUseCase->handle($input);
        
        return response()->json([
            'message' => $output->message,
        ], 201);
    }
    
    /**
     * 店舗の弁当提供情報を更新する
     */
    public function updateStoreBoxLunch(Request $request, string $storeId, string $boxLunchId)
    {
        $request->validate([
            'is_available' => 'required|boolean',
        ]);
        
        $input = new UpdateStoreBoxLunchInputData(
            $storeId,
            $boxLunchId,
            $request->input('is_available')
        );
        
        $output = $this->updateStoreBoxLunchUseCase->handle($input);
        
        return response()->json([
            'message' => $output->message,
        ]);
    }
    
    /**
     * 店舗の配達可能エリア情報を作成する
     */
    public function createStoreArea(Request $request, string $storeId)
    {
        $request->validate([
            'area_id' => 'required|string',
            'is_deliverable' => 'nullable|boolean',
        ]);
        
        $input = new CreateStoreAreaInputData(
            $storeId,
            $request->input('area_id'),
            $request->input('is_deliverable', true)
        );
        
        $output = $this->createStoreAreaUseCase->handle($input);
        
        return response()->json([
            'message' => $output->message,
        ], 201);
    }
    
    /**
     * 店舗の配達可能エリア情報を更新する
     */
    public function updateStoreArea(Request $request, string $storeId, string $areaId)
    {
        $request->validate([
            'is_deliverable' => 'required|boolean',
        ]);
        
        $input = new UpdateStoreAreaInputData(
            $storeId,
            $areaId,
            $request->input('is_deliverable')
        );
        
        $output = $this->updateStoreAreaUseCase->handle($input);
        
        return response()->json([
            'message' => $output->message,
        ]);
    }
}

