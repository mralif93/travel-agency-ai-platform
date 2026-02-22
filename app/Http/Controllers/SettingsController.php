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
            'theme_mode' => ['sometimes', 'string', 'in:light,dark,system'],
            'theme_color' => ['sometimes', 'string', 'in:primary,rose,blue,green,orange,violet'],
        ]);

        $request->user()->update($validated);

        if ($request->has('theme_mode') && !$request->has('theme_color')) {
            return response()->json(['success' => true]);
        }

        return Redirect::route('settings.edit')->with('status', 'settings-updated');
    }
}
