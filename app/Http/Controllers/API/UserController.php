<?php

namespace App\Http\Controllers\API;

use Str;
use Auth;
use App\User;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPutPatch;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::withTrashed()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserPost $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserPost $request)
    {
        $filled = $request->only((new User)->getFillable());
        $filled['password'] = bcrypt($filled['password']);
        $inputs['api_token'] = date('dmYHis') . Str::random(46);
        $newUser = User::create($filled);
        $newUser->forceFill(['api_token' => date('dmYHis') . Str::random(46)])->save();
        $newUser->assignRole($request->get('profile', 'USUARIO'));

        return response()->json($newUser->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->can('view', $user))
            return response()->json(User::findOrFail($id)->toArray());
        else return response()->json('Unauthorized', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserPutPatch $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPutPatch $request, $id)
    {
        $user = User::findOrFail($id);
        $filled = $request->only($user->getFillable());
        if (!$user->update($filled)) return response()->json("Update user $id failed", 500);
        $user->syncRoles($request->get('profile', 'USUARIO'));

        return response()->json($user->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->can('delete', $user)) {
            try {
                if (!$user->delete()) return response()->json("Delete user $id failed", 500);
            } catch (Exception $exception) {
                return response()->json($exception->getTrace(), 500);
            }

            return response()->json($user->toArray());
        } else response()->json('Unauthorized', 403);
    }
}
