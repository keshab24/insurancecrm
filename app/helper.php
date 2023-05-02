<?php

use App\Models\KYC;
use App\Models\User;
use App\Models\Company;
use App\Models\Feature;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductFeature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

function control($permission)
{
    $permissions_exist = 0;
    $user_id = Auth::user()->id;
    $permission_id = DB::table('permissions')->where('name', $permission)->first();
    $role_id = Auth::user()->role_id;
    if (($permission_id != null || $permission_id != '') && ($role_id != '' || $role_id != null))
        $permissions_exist = DB::table('permission_role')->where([
            ['permission_id', '=', $permission_id->id], ['role_id', '=', $role_id]
        ])->count();
    //    if($user_id == 1){
    //        return true;
    //    }
    if (isset($permissions_exist) && $permissions_exist > 0) {
        return true;
    } else {
        return false;
    }
}

function getPrefix()
{
    if (Auth::check()) {
        $user_id = Auth::user()->id;
        $role_id = DB::table('role_user')->where('user_id', $user_id)->first();
        $roles = DB::table('roles')->where('id', $role_id->role_id)->first();
        if ($role_id) {
            return STR::slug($roles->display_name);
        } else {
            return "admin";
        }
    }
}

function AgentCat()
{
    $companyID = count(Auth::user()->userAgents) ? Auth::user()->userAgents->pluck('company_id') : '';
    //    dd($companyID);
    if ($companyID) {
        $cat = Company::whereIn('id', $companyID)->pluck('type');
        return $cat->toArray();
    } else {
        $a = array('all');
        return $a;
    }
}
function getProductName($prodId)
{
    return Product::where('id', $prodId)->first()->name;
}

function featureName($code)
{
    if(isset($code)){
    return Feature::where('code', $code)->first()->name;
    }
    else{
        null;
    }
}
function featureCode($code)
{
    if(isset($code)){
    return Feature::where('code', $code)->first();
    }
    else{
        null;
    }
}


function findcatFeature($category)
    {
        $products = Product::where('category', $category)->pluck('id');
        $featureIds = ProductFeature::whereIn('product_id', $products->toArray())->pluck('feature_id');
        
        return $feature = Feature::whereIn('id', $featureIds)->get();
        
        // return Response()::json(array('success' => true, 'data' => $data));
    }

function customerKyc($id)
{
    return KYC::where('customer_id', $id)->first();
}
function getProductList($prodId)
{
    return Product::whereIn('id', $prodId)->get();
}
function getProductId($prodId)
{
    return Product::where('id', $prodId)->first()->id;
}

function AgentCategories()
{
    $companyID = count(Auth::user()->userAgents) ? Auth::user()->userAgents->unique('company_id')->pluck('company_id') : '';
    //    dd( $companyID);
    if ($companyID) {
        return $companyID->toArray();
    } else {
        $a = array('all');
        return $a;
    }
}

// limit the no of characters
function text_limit($x, $length)
{
    if (strlen($x) <= $length)
        return $x;
    else
        return substr($x, 0, $length) . ' ...';
}


// return role of the user
function getRole($user_id)
{
    return User::findOrFail($user_id)->role_id;
}


function convertCurrency($number)
{
    // Convert Price to Crores or Lakhs or Thousands
    $length = strlen($number);
    $currency = '';

    if($length == 4 || $length == 5)
    {
        // Thousand
        $number = $number / 1000;
        $number = round($number,2);
        $ext = "Thousand";
        $currency = $number." ".$ext;
    }
    elseif($length == 6 || $length == 7)
    {
        // Lakhs
        $number = $number / 100000;
        $number = round($number,2);
        $ext = "Lac";
        $currency = $number." ".$ext;

    }
    elseif($length == 8 || $length == 9)
    {
        // Crores
        $number = $number / 10000000;
        $number = round($number,2);
        $ext = "Cr";
        $currency = $number.' '.$ext;
    }

    return $currency;
}
