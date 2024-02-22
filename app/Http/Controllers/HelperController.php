<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class HelperController extends Controller
{
    public function convertDateToArabic(Request $request)
    {
        $date = Carbon::parse($request->date);
        return $date->toHijri()->locale('ar')->isoFormat('llll');
        return $date;
    }
}
