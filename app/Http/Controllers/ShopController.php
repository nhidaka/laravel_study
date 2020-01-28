<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        $stocks = Stock::Paginate(6); //Eloquantで検索
        return view('shop',compact('stocks'));
    }

    public function myCart()
    {
        $carts = Cart::all(); //Eloquantで検索
        return view('mycart',compact('carts'));
    }

    public function addMycart(Request $request)
    {
        // ログイン状態のユーザーのidを取得
        $user_id = Auth::id();

        // POST送信で送られてきたstock_idを取得
        $stock_id=$request->stock_id;
        $message = '';

        $cart_add_info=Cart::firstOrCreate(['stock_id' => $stock_id,'user_id' => $user_id]);

        if($cart_add_info->wasRecentlyCreated){
            $message = 'カートに追加しました';
        }
        else{
            $message = 'カートに登録済みです';
        }

        $carts = Cart::where('user_id',$user_id)->get();

        return view('mycart',compact('carts', 'message'));

    }
}
