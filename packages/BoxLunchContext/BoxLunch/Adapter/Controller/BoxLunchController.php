<?php
namespace Packages\BoxLunchContext\BoxLunch\Adapter\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\BoxLunchContext\BoxLunch\UseCase\ListBoxLunches\IListBoxLunchesUseCase;
use Packages\BoxLunchContext\BoxLunch\UseCase\ListBoxLunches\ListBoxLunchesInputData;
use Packages\BoxLunchContext\BoxLunch\UseCase\GetBoxLunchDetail\IGetBoxLunchDetailUseCase;
use Packages\BoxLunchContext\BoxLunch\UseCase\GetBoxLunchDetail\GetBoxLunchDetailInputData;
use Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration\ICreateBoxLunchConfigurationUseCase;
use Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration\CreateBoxLunchConfigurationInputData;
use Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration\CreateBoxLunchConfigurationOptionSelectionInputData;

class BoxLunchController extends Controller
{
    public function __construct(
        private readonly IListBoxLunchesUseCase $listBoxLunchesUseCase,
        private readonly IGetBoxLunchDetailUseCase $getBoxLunchDetailUseCase,
        private readonly ICreateBoxLunchConfigurationUseCase $createBoxLunchConfigurationUseCase
    ) {}
    
    /**
     * 店舗のBox Lunch一覧を取得する
     */
    public function index(Request $request)
    {
        $request->validate([
            'store_id' => 'required|string',
        ]);
        
        $input = new ListBoxLunchesInputData($request->input('store_id'));
        $output = $this->listBoxLunchesUseCase->handle($input);
        
        return response()->json($output->boxLunches);
    }
    
    /**
     * Box Lunchの詳細を取得する
     */
    public function show(string $boxLunchId)
    {
        $input = new GetBoxLunchDetailInputData($boxLunchId);
        $output = $this->getBoxLunchDetailUseCase->handle($input);
        
        return response()->json($output->boxLunch);
    }
    
    /**
     * Box Lunch構成を作成する
     */
    public function createConfiguration(Request $request)
    {
        $request->validate([
            'box_lunch_id' => 'required|string',
            'availability_status' => 'required|string|in:available,unavailable,out_of_stock',
            'selections' => 'required|array|min:0',
            'selections.*.option_id' => 'required|string',
            'selections.*.quantity' => 'required|integer|min:1',
        ]);
        
        $selections = [];
        foreach ($request->input('selections') as $selection) {
            $selections[] = new CreateBoxLunchConfigurationOptionSelectionInputData(
                $selection['option_id'],
                (int)$selection['quantity']
            );
        }
        
        $input = new CreateBoxLunchConfigurationInputData(
            $request->input('box_lunch_id'),
            $request->input('availability_status'),
            $selections
        );
        
        $output = $this->createBoxLunchConfigurationUseCase->handle($input);
        
        return response()->json([
            'configuration_id' => $output->configurationId,
            'total_price' => $output->totalPrice,
            'message' => $output->message,
        ], 201);
    }
}



