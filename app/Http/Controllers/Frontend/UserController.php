<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function edit()
    {
        $user = User::find(auth()->user()->id);
        return view('auth.profile', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = auth()->user()->whereId($id)->first();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'avatar' => 'nullable|image|max:20000|mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['birth_date'] = $request->birth_date;

        $fileName = "";
        if ($request->hasFile('avatar'))
        {
            if (auth()->user()->avatar != '') {
                if (File::exists('images/users/' . auth()->user()->avatar)) {
                    unlink('images/users/' . auth()->user()->avatar);
                }
            }
            $file = $request->file('avatar');
            $fileName = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/users/', $fileName);

        }

        if (strlen($fileName > 0))
        {
            $data['avatar'] = $fileName;
        }

        $update = $user->update($data);

        if ($update) {
            return redirect()->back()->with([
                'message' => 'Information updated successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }


    public function destroy($id)
    {
        //
    }
}
