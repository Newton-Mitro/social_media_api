<?php

namespace App\Modules\Friend\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Friend\Infrastructure\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendRequestController extends Controller
{
    // Send a friend request
    public function sendRequest(Request $request, $receiverId)
    {
        $senderId = Auth::id();

        // Check if a request already exists
        $existingRequest = FriendRequest::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->first();

        if ($existingRequest) {
            return response()->json(['message' => 'Friend request already exists.'], 400);
        }

        // Create the friend request
        FriendRequest::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Friend request sent successfully.'], 201);
    }

    // Accept a friend request
    public function acceptRequest($requestId)
    {
        $friendRequest = FriendRequest::findOrFail($requestId);

        // Ensure the authenticated user is the receiver
        if ($friendRequest->receiver_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $friendRequest->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend request accepted.']);
    }

    // Reject a friend request
    public function rejectRequest($requestId)
    {
        $friendRequest = FriendRequest::findOrFail($requestId);

        // Ensure the authenticated user is the receiver
        if ($friendRequest->receiver_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $friendRequest->update(['status' => 'rejected']);

        return response()->json(['message' => 'Friend request rejected.']);
    }

    // Check the status of a friend request between two users
    public function checkStatus($userId, $otherUserId)
    {
        $friendRequest = FriendRequest::where(function ($query) use ($userId, $otherUserId) {
            $query->where('sender_id', $userId)->where('receiver_id', $otherUserId);
        })->orWhere(function ($query) use ($userId, $otherUserId) {
            $query->where('sender_id', $otherUserId)->where('receiver_id', $userId);
        })->first();

        if (!$friendRequest) {
            return response()->json(['status' => 'no request']);
        }

        return response()->json(['status' => $friendRequest->status]);
    }

    public function pendingRequestCount()
    {
        $userId = Auth::id();

        // Count pending friend requests where the authenticated user is the receiver
        $pendingRequestsCount = FriendRequest::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->count();

        return response()->json(['pending_requests_count' => $pendingRequestsCount]);
    }

    public function friendsList(Request $request, string $userId)
    {
        // Define the number of items per page, with a default of 10 if not specified
        $perPage = $request->get('per_page', 10);

        // Get list of user IDs where there's an accepted friendship with the given user
        $friendIds = DB::table('friend_requests')
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->where('status', 'accepted')
            ->pluck('sender_id', 'receiver_id') // Pluck both IDs
            ->flatten() // Flatten array to a single list
            ->unique() // Ensure no duplicates
            ->reject(fn($id) => $id === $userId); // Exclude the current user ID

        // Fetch the User records for these IDs with pagination
        $friends = User::whereIn('id', $friendIds)
            ->paginate($perPage);

        return response()->json($friends);
    }
}
