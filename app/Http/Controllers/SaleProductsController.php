<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleProducts;
use App\Models\UserSale;
use Illuminate\Support\Facades\DB;

class SaleProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $saleProducts = $request->post();
        $resultSaleProducts = [];
        if ($saleProducts) {
            $code = sha1(uniqid(time() . rand(1, 500), true));
            $newUserSale = [
                'totalValue' => $saleProducts->totalValue,
                'codeSale' => $code,
                'user_id' => $saleProducts->user_id,
            ];
            $userSale = UserSale::create($newUserSale);
            foreach ($saleProducts->products as $item) {
                $item->user_sale_id = $userSale->id;
                $product = SaleProducts::create($item);
                array_push($resultSaleProducts, $product);
            }

            return response()->json([
                'saleProducts' => $resultSaleProducts,
                'message' => 'compra guardada'
            ], 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $results = DB::table('user_sales')
            ->join('users', 'users.id', '=', 'user_sales.user_id')
            ->join('sale_products', 'sale_products.user_sale_id', '=', 'user_sales.id')
            ->join('products', 'products.id', '=', 'sale_products.products_id')
            ->select('user_sales.*', 'users.name as userName', 'products.name as productName', 'products.value as productValue')
            ->where('user_sales.id', '=', $id)->get();

        if ($results) {
            return response()->json($results, 200);
        }
        else {
            return response()->json($message = 'No hay datos existente', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mySaleProducts ($id) {
        $saleProducts = UserSale::all()->where('user_id', '=', $id);
        if ($saleProducts) {
            return response()->json([
                'saleProducts' => $saleProducts,
                'message' => 'Mis compras'
            ], 200);
        } else {
            return response()->json($message = 'no has realizado compras hasta la fecha', 400);
        }
    }
}
