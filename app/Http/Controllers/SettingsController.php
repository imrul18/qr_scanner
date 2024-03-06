<?php

namespace App\Http\Controllers;

use App\Models\FontStyle;
use App\Models\MasterSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    function settingsPage()
    {
        $settings = MasterSetting::all();
        $font_styles = FontStyle::all();
        return view('pages/settings/index', compact('settings', 'font_styles'));
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
                    $file->move('file/files', end($filename));
                }
            }
        }

        $styles = FontStyle::get();
        foreach ($styles as $style) {
            $style->delete();
        }
        foreach ($request->font_name as $key => $name) {
            if ($name != null && $request->font_family[$key] != null) {
                $font = new FontStyle();
                $font->name = $name;
                $font->font_family = $request->font_family[$key];
                $font->save();
            }
        }
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
