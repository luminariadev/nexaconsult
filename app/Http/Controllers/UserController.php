<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use MongoDB\BSON\Exception\InvalidArgumentException;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserService $userService)
    {
        $this->users = $userService;
    }

    // --------------------------------------------------
    // GET /api/users (search + filter + sort + pagination)
    // --------------------------------------------------
    public function index()
    {
        // Ambil semua query params langsung:
        // search, role, status, sort, page, limit, dll
        $params = request()->query();

        $result = $this->users->filter($params);

        return response()->json($result);
    }

    // --------------------------------------------------
    // GET /api/users/{id}
    // --------------------------------------------------
    public function show($id)
    {
        try {
            $user = $this->users->find($id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data'   => $user
            ]);
        } catch (InvalidArgumentException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ID format'
            ], 400);
        }
    }

    // --------------------------------------------------
    // POST /api/users
    // --------------------------------------------------
    public function store(StoreUserRequest $request)
    {
        $data = $this->users->create($request->validated());

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ], 201);
    }

    // --------------------------------------------------
    // PUT /api/users/{id}
    // --------------------------------------------------
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $updated = $this->users->update($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data'   => $updated
            ]);
        } catch (InvalidArgumentException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ID format'
            ], 400);
        }
    }

    // --------------------------------------------------
    // DELETE /api/users/{id}
    // --------------------------------------------------
    public function destroy($id)
    {
        try {
            $result = $this->users->delete($id);

            if (!$result['deleted']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted'
            ]);
        } catch (InvalidArgumentException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ID format'
            ], 400);
        }
    }
}
