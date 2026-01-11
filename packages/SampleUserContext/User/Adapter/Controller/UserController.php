<?php
namespace Packages\UserContext\User\Adapter\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Packages\User\User\UseCase\ListUsers\IListUsersUseCase;
use Packages\User\User\UseCase\UpdateUser\IUpdateUserUseCase;
use Packages\User\User\UseCase\UpdateUser\UpdateUserInputData;
use Packages\User\User\UseCase\DeleteUser\IDeleteUserUseCase;
use Packages\User\User\UseCase\DeleteUser\DeleteUserInputData;

class UserController extends Controller
{
    private IListUsersUseCase $listUsersUseCase;
    private IUpdateUserUseCase $updateUserUseCase;
    private IDeleteUserUseCase $deleteUserUseCase;

    public function __construct(
        IListUsersUseCase $listUsersUseCase,
        IUpdateUserUseCase $updateUserUseCase,
        IDeleteUserUseCase $deleteUserUseCase
    ) {
        $this->listUsersUseCase = $listUsersUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
        $this->deleteUserUseCase = $deleteUserUseCase;
    }

    public function index()
    {
        $output = $this->listUsersUseCase->handle();
        return response()->json($output->users);
    }

    public function update(Request $request, int $id)
    {
        $input = new UpdateUserInputData(
            $id,
            $request->input('name'),
            $request->input('email')
        );

        $output = $this->updateUserUseCase->handle($input);
        return response()->json(['message' => $output->message]);
    }

    public function destroy(int $id)
    {
        $input = new DeleteUserInputData($id);
        $output = $this->deleteUserUseCase->handle($input);

        return response()->json(['message' => $output->message]);
    }
}

