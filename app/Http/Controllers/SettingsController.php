<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    /**
     * Display the settings form.
     */
    public function edit(Request $request)
    {
        return view('settings.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme_mode' => ['required', 'string', 'in:light,dark,system'],
            'theme_color' => ['required', 'string', 'in:primary,rose,blue,green,orange,violet'],
        ]);

        $request->user()->update($validated);

        return Redirect::route('settings.edit')->with('status', 'settings-updated');
    }
}
