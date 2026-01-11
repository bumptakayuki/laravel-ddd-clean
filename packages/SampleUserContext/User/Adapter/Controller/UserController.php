<?php
namespace Packages\SampleUserContext\User\Adapter\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Packages\SampleUserContext\User\UseCase\ListUsers\IListUsersUseCase;
use Packages\SampleUserContext\User\UseCase\UpdateUser\IUpdateUserUseCase;
use Packages\SampleUserContext\User\UseCase\UpdateUser\UpdateUserInputData;
use Packages\SampleUserContext\User\UseCase\DeleteUser\IDeleteUserUseCase;
use Packages\SampleUserContext\User\UseCase\DeleteUser\DeleteUserInputData;

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

        $this->updateUserUseCase->handle($input);
        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy(int $id)
    {
        $input = new DeleteUserInputData($id);
        $this->deleteUserUseCase->handle($input);

        return response()->json(['message' => 'User deleted successfully']);
    }
}

