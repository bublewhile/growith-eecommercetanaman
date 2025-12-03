<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class StaffController extends Controller
{
    public function dashboard()
    {
        $totalPromo = Promo::count();

        return view('staff.dashboard', compact('totalPromo'));
    }
}
