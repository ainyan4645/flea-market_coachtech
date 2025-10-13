<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function mypageEdit() {
        $profile = Profile::where('user_id', Auth::id())->first();
        return view('mypage.mypage_edit', compact('profile'));
    }

    public function update(ProfileRequest $request) {
        $profile = Profile::firstOrNew(['user_id' => Auth::id()]);

        $profile->name = $request->name;
        $profile->postal_code = $request->postal_code;
        $profile->address = $request->address;
        $profile->building = $request->building;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image = $path;
        }

        $profile->save();

        return redirect('/');
    }

    public function mypage() {
        return view('mypage.mypage');
    }
}
