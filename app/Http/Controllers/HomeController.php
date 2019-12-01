<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Products;
use App\Models\Brand;
use App\Models\MotorType;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function getHome() {

        $products = Products::with('photos','user')->orderBy('created_at','DESC')->get();
        $featured_products = Products::with('photos','user')->where('is_featured',1)->orderBy('created_at','DESC')->get();
        $products_automatic = Products::with('photos','user')->where('brand_type','Automatic')->orderBy('created_at','DESC')->take(5)->get();
        $products_business = Products::with('photos','user')->where('brand_type','Business')->orderBy('created_at','DESC')->take(5)->get();
        $products_sports = Products::with('photos','user')->where('brand_type','Sports')->orderBy('created_at','DESC')->take(5)->get();

        return view('home')
            ->with('products',$products)
            ->with('featured_products',$featured_products)
            ->with('products_automatic',$products_automatic)
            ->with('products_business',$products_business)
            ->with('products_sports',$products_sports);
    }

    public function getProductDetails($slug) {

        $product = Products::with('photos','user')->where('slug',$slug)->first();

        if($product){

            $random_product = Products::with('photos')->where('id', '!=', $product->id)->take(3)->inRandomOrder()->get();

            return view('products.detail')->with('product',$product)->with('random_product',$random_product);
        }else{

            return abort(404);
        }

    }

    public function getProducts(Request $request) {
        
        
        $brands = Brand::get();
        $motor_types = MotorType::get();

        if($request->q) {

            $search = strtolower($request->q);

            $products = Products::with('photos')->where('title','like', '%'.$search.'%')->orderBy('created_at','DESC')->paginate(1);

        } elseif($request->type) {

            $type = strtolower($request->type);

            $products = Products::with('photos')->where('brand_type','like', '%'.$type.'%')->orderBy('created_at','DESC')->paginate(1);

        } elseif($request->brand) {

            $brand = strtolower($request->brand);

            $products = Products::with('photos')->where('product_brand','like', '%'.$brand.'%')->orderBy('created_at','DESC')->paginate(1);

        } else {

            $products = Products::with('photos')->orderBy('created_at','DESC')->paginate(1);
        }

        if($products->isEmpty()) {
        
            return redirect('/');
        
        }

        $featured_products = Products::with('photos')->where('is_featured',1)->take(3)->inRandomOrder()->get();

        return view('products.index')
            ->with('products',$products)
            ->with('featured_products',$featured_products)
            ->with('brands',$brands)
            ->with('motor_types',$motor_types);
    }
}
