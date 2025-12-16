<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class StaffController extends Controller
{
    public function dashboard()
    {
        $today = now();
        $totalPromoAktif = Promo::whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->count();

        $totalPromoTidakAktif = Promo::where(function ($q) use ($today) {
            $q->whereDate('end_date', '<', $today)->orWhereDate('start_date', '>', $today);
        })->count();

        return view('staff.dashboard', compact('totalPromoAktif', 'totalPromoTidakAktif'));
    }
}
