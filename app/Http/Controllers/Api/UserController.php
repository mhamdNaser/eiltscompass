<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\imageTrait;
use App\Http\Requests\User\ActiveUserRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UserController extends Controller
{
    use imageTrait;
    public function index(SearchRequest $request)
    {
        $searchWord = $request->input('searchWord');
        $paginateNumber = $request->input('numberParam');
        $users = User::where('is_activated', true);

        if (!$searchWord) {
            $users = $users->whereIn('role', ['student', 'admin', 'super admin'])
            ->paginate($paginateNumber);
            return UserResource::collection($users);
        }

        if (empty($searchWord)) {
            $users = $users->whereIn('role', ['student', 'admin', 'super admin'])
            ->paginate($paginateNumber);
            return UserResource::collection($users);
        } else {
            $users = $users->where(function ($query) use ($searchWord) {
                $query->where('first_name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('country', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('phone', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('role', 'LIKE', '%' . $searchWord . '%');
            })
                ->paginate($paginateNumber);

            $userData = $users->mapWithKeys(function ($user) {
                return [$user->id => $user->toArray()];
            });

            return UserResource::collection($users);
        }
    }



    public function showDeletedUser(SearchRequest $request)
    {
        $searchWord = $request->input('searchWord');
        $paginateNumber = $request->input('numberParam');
        $users = User::where('is_activated', false);

        if (!$searchWord) {
            $users = $users->whereIn('role', ['student', 'admin', 'super admin'])
            ->paginate($paginateNumber);
            return UserResource::collection($users);
        }

        if (empty($searchWord)) {
            $users = $users->whereIn('role', ['student', 'admin', 'super admin'])
            ->paginate($paginateNumber);
            return UserResource::collection($users);
        } else {
            $users = $users->where(function ($query) use ($searchWord) {
                $query->where('first_name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('country', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('phone', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('role', 'LIKE', '%' . $searchWord . '%');
            })
                ->paginate($paginateNumber);

            return UserResource::collection($users);
        }
    }

    public function userNumber()
    {
        $excludedRoles = ['student'];
        return User::whereIn('role', $excludedRoles)->where('status', 'active')->pluck('id')->count();
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image, 'uploads/images/users');
        $data['password'] = Hash::make($request->password);
        $store = User::create($data);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Store User Successfully',
        ]);
        DB::rollBack();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\Models\User                     $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();
        $user = User::find($id);
        $data = $request->all();
        $user->update([
            'first_name'    => $request->first_name ?? $user->first_name,
            'last_name'     => $request->last_name ?? $user->last_name,
            'country'       => $request->country ?? $user->country,
            'status'        => $request->status ?? $user->status,
            'role'          => $request->role ?? $user->role,
            'phone'          => $request->phone ?? $user->phone,
        ]);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Update User Successfully',
        ]);
        DB::rollBack();
    }

    public function activeUser(ActiveUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update($data);

        return new UserResource($user);
    }

    public function deleteUser(DeleteRequest $request)
    {
        $userId = $request->input('selectedRows');
        $usersData = [];

        foreach ($userId as $key => $value) {
            // Ensure $value is an array
            $userIdsArray = is_array($value) ? $value : [$value];

            $users = User::whereIn('id', $userIdsArray)->get(); // Use get() instead of first()

            // Update each user in the collection
            foreach ($users as $user) {
                $user->update(['is_activated' => false]);
                $usersData[] = $user;
            }
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Update User Successfully',
        ]);
        DB::rollBack();
    }

    public function resetUser(DeleteRequest $request)
    {
        $userId = $request->input('selectedRows');
        $usersData = [];

        foreach ($userId as $key => $value) {
            // Ensure $value is an array
            $userIdsArray = is_array($value) ? $value : [$value];

            $users = User::whereIn('id', $userIdsArray)->get(); // Use get() instead of first()

            // Update each user in the collection
            foreach ($users as $user) {
                $user->update(['is_activated' => true]);
                $usersData[] = $user;
            }
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Update User Successfully',
        ]);
        DB::rollBack();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response("", 204);
    }
}