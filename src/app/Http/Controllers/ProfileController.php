<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('mypage.profile');
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->postcode = $validated['postcode'];
        $user->address = $validated['address'];
        $user->building = $validated['building'];

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('public/icons');
            $user->icon = basename($path);
        }

        $user->save();

        return redirect()->route('items.index');
    }
}
