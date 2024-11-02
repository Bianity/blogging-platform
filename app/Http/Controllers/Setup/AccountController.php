<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Auth\CreateNewAdminController;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('setup.account');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = (new CreateNewAdminController())->create($request->input());

        $user->profile()->create();

        $user->assignRole('administrator');

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->route('setup.complete');
    }
}
