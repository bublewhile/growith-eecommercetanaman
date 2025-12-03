<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProduk = Product::count();
        $totalUser = User::count();

        return view('admin.dashboard', compact('totalProduk', 'totalUser'));
    }
}
