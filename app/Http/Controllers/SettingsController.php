<?php

namespace App\Http\Controllers;

use App\Models\MasterSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    function settingsPage()
    {
        $settings = MasterSetting::get();
        return view('pages/settings/index', compact('settings'));
    }

    public function settingsupdate(Request $request)
    {
        $settings = MasterSetting::get();
        foreach ($settings as $setting) {
            if ($setting->type == 1 && $setting->value != $request->input($setting->key)) {
                info($request->input($setting->key));
                $setting->value = $request->input($setting->key);
                $setting->save();
            }
            if ($setting->type == 2) {
                if ($request->hasFile($setting->key)) {
                    $filename = explode('/', $setting->value);
                    $file = $request->file($setting->key);
                    if ($setting->value && Storage::exists($setting->value)) {
                        Storage::delete($setting->value);
                    }
                    $file->storeAs('public/files', end($filename));
                }
            }
        }
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
