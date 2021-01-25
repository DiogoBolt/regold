<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Product;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class FavoriteController extends Controller
{
    public function getFavorites()
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');
        $favourites = Favorite::from(Favorite::alias('fav'))
        ->leftJoin(Product::alias('p'), 'p.id', '=', 'fav.product_id')
        ->select(['p.name', 'p.id', 'p.file' ])
        ->where('fav.user_id', '=', $auxClientId)
        ->get();

        return view('frontoffice/favourites', compact('favourites'));
    }

    public function addFavorite($productId)
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');
        $favourite = new Favorite;
        $favourite->user_id = $auxClientId;
        $favourite->product_id = $productId;
        $favourite->save();

        return ['success' => 'Added successfully to Favourites.'];
    }

    public function deleteFavorite($productId) 
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $favourite = Favorite::where('product_id', '=', $productId)
        ->where('user_id', '=', $auxClientId)
        ->first();

        $favourite->delete();

        return ['success' => 'Removed successfully from Favourites.'];
    }
}
