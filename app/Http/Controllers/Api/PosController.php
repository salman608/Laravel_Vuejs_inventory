<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function getProduct($id)
    {
        $product = DB::table('products')
            ->where('category_id', $id)
            ->get();

        return response()->json($product);
    }

    public function OrderComplete(Request $request)
    {
        $validatedata = $request->validate([
            'customer_id' => 'required',
            'payby' => 'required',
        ]);

        $data = array();
        $data['customer_id'] = $request->customer_id;
        $data['qty'] = $request->qty;
        $data['sub_total'] = $request->subtotal;
        $data['vat'] = $request->vat;
        $data['total'] = $request->total;
        $data['pay'] = $request->pay;
        $data['due'] = $request->due;
        $data['payby'] = $request->payby;
        $data['order_date'] = date('d/m/Y');
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');
        $order_id = DB::table('orders')->insertGetId($data);

        $contents = DB::table('pos')->get();
        $odata = array();
        foreach ($contents as $content) {
            $odata['order_id'] = $order_id;
            $odata['product_id'] = $content->pro_id;
            $odata['product_quantity'] = $content->pro_quantity;
            $odata['product_price'] = $content->product_price;
            $odata['sub_total'] = $content->sub_total;
            $odata['sub_total'] = $content->sub_total;
            DB::table('order_details')->insert($odata);

            DB::table('products')
                ->where('id', $content->pro_id)
                ->update(['product_quantity' => DB::raw('product_quantity -' . $content->pro_quantity)]);
        }

        DB::table('pos')->delete();
        return response('Done');
    }

    // Admin dash board

    public function TodaySell()
    {
        $date = date('d/m/Y');
        $sell = DB::table('orders')
            ->where('order_date', $date)->sum('total');

        return response()->json($sell);
    }

    public function TodayIncome()
    {
        $date = date('d/m/Y');
        $income = DB::table('orders')
            ->where('order_date', $date)->sum('pay');

        return response()->json($income);
    }

    public function TodayDue()
    {
        $date = date('d/m/Y');
        $due = DB::table('orders')
            ->where('order_date', $date)->sum('due');

        return response()->json($due);
    }

    public function TodayExpense()
    {
        $date = date('d/m/y');
        $expense = DB::table('expenses')
            ->where('expense_date', $date)->sum('amount');

        return response()->json($expense);
    }

    public function TodayStockout()
    {
        $product = DB::table('products')->where('product_quantity', '<', '1')->get();
        return response()->json($product);
    }
}
