<?php

namespace App\Http\Controllers\AdminPurchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('admin-purchasing.index');
    }
}
