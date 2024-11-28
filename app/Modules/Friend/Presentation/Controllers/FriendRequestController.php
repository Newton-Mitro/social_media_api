<?php

namespace App\Modules\Friend\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Friend\Application\UseCases\AcceptFriendRequestUseCase;
use App\Modules\Friend\Application\UseCases\GetFriendsListUseCase;
use App\Modules\Friend\Application\UseCases\RejectFriendRequestUseCase;
use App\Modules\Friend\Application\UseCases\SendFriendRequestUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{

    public function __construct(
        protected readonly SendFriendRequestUseCase $sendFriendRequestUseCase,
        protected readonly  AcceptFriendRequestUseCase $acceptFriendRequestUseCase,
        protected readonly  RejectFriendRequestUseCase $rejectFriendRequestUseCase,
        protected readonly  GetFriendsListUseCase $getFriendsListUseCase
    ) {}

    public function sendRequest(Request $request, string $receiverId)
    {
        try {
            $this->sendFriendRequestUseCase->execute(Auth::id(), $receiverId);
            return response()->json(['message' => 'Friend request sent successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function acceptRequest(string $requestId)
    {
        try {
            $this->acceptFriendRequestUseCase->execute($requestId, Auth::id());
            return response()->json(['message' => 'Friend request accepted.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function rejectRequest(string $requestId)
    {
        try {
            $this->rejectFriendRequestUseCase->execute($requestId, Auth::id());
            return response()->json(['message' => 'Friend request rejected.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function friendsList(Request $request, string $userId)
    {
        try {
            $friends = $this->getFriendsListUseCase->execute($userId);
            $perPage = $request->get('per_page', 10);

            // Paginate the friends collection
            $paginatedFriends = $friends->forPage($request->get('page', 1), $perPage);

            return response()->json($paginatedFriends->values());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
