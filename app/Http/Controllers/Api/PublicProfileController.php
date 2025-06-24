<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load(['projects' => function ($query) {
            $query->where('visibility', 'public')->with('skills');
        }]);

        return new UserResource($user);
    }
}
