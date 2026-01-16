<?php
namespace Packages\AreaContext\Area\Adapter\Controller;

use App\Http\Controllers\Controller;
use Packages\AreaContext\Area\UseCase\ListAreas\IListAreasUseCase;
use Packages\AreaContext\Area\UseCase\ListAreas\ListAreasInputData;
use Packages\AreaContext\Area\UseCase\GetArea\IGetAreaUseCase;
use Packages\AreaContext\Area\UseCase\GetArea\GetAreaInputData;

class AreaController extends Controller
{
    public function __construct(
        private readonly IListAreasUseCase $listAreasUseCase,
        private readonly IGetAreaUseCase $getAreaUseCase
    ) {}
    
    /**
     * エリア一覧を取得する
     */
    public function index()
    {
        $input = new ListAreasInputData();
        $output = $this->listAreasUseCase->handle($input);
        
        return response()->json($output->areas);
    }
    
    /**
     * エリアの詳細を取得する
     */
    public function show(string $areaId)
    {
        $input = new GetAreaInputData($areaId);
        $output = $this->getAreaUseCase->handle($input);
        
        if (!$output->area) {
            return response()->json(['message' => 'エリアが見つかりませんでした。'], 404);
        }
        
        return response()->json($output->area);
    }
}


