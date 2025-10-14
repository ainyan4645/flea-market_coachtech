<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function confirm($id)
    {
        $product = Product::findOrFail($id);
        return view('purchase.confirm', compact('product'));
    }
}
