<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailProductController extends Controller
{
    public function detail()
    {
        return view('pages.pembeli.detail_product');
    }
}
