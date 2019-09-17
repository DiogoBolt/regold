<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Product;
use Illuminate\Http\Request;
use Auth;

class FavoriteController extends Controller
{
    public function getFavorites()
    {
        $user = Auth::user();
        $favourites = Favorite::from(Favorite::alias('fav'))
        ->leftJoin(Product::alias('p'), 'p.id', '=', 'fav.product_id')
        ->select(['p.name', 'p.id', 'p.file' ])
        ->where('fav.user_id', '=', $user->id)
        ->get();

        return view('frontoffice/favourites', compact('favourites'));
    }

    public function addFavorite($productId)
    {
        $user = Auth::user();
        $favourite = new Favorite;
        $favourite->user_id = $user->id;
        $favourite->product_id = $productId;
        $favourite->save();

        return ['success' => 'Added successfully to Favourites.'];
    }

    public function deleteFavorite($productId) 
    {
        $user = Auth::user();

        $favourite = Favorite::where('product_id', '=', $productId)
        ->where('user_id', '=', $user->id)
        ->first();

        $favourite->delete();

        return ['success' => 'Removed successfully from Favourites.'];
    }
}
