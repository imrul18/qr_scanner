<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function convertDateToArabic(Request $request)
    {
        $date = $request->date;
        $date = str_replace('0', '٠', $date);
        $date = str_replace('1', '١', $date);
        $date = str_replace('2', '٢', $date);
        $date = str_replace('3', '٣', $date);
        $date = str_replace('4', '٤', $date);
        $date = str_replace('5', '٥', $date);
        $date = str_replace('6', '٦', $date);
        $date = str_replace('7', '٧', $date);
        $date = str_replace('8', '٨', $date);
        $date = str_replace('9', '٩', $date);
        return $date;
    }
}
