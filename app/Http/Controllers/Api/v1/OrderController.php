<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\MainController as MainController;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends MainController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data['order'] =  Order::with(['product'])->get();
        return $this->successResponse($data, 'All Order List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->only('user_id','name','phone','address','product_id','price','quantity','total_price'));
        return $this->successResponse($order, 'Order Created Successfully', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        $data['order'] = $order->first();
        return $this->successResponse($data, 'All Order List');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        if ($order->status == 'Pending'){
            $order->update($request->only('quantity','total_price'));
            $data['order'] =  $order;
            return $this->successResponse($data, 'Order Updated Successfully', Response::HTTP_OK);
        }
        else{
            return $this->errorResponse('failed', 'Sorry you are not allowed to edit this Order', Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order)
    {
        if (Auth::user()->is_admin == 1) {
            $order->delete();
            return $this->successResponse('Deleted', 'Order Deleted Successfully');
        }
        else{
            return $this->errorResponse('Unauthorized', 'Sorry you are not authorized to perform this action.');
        }
    }

    public function statusUpdate(Order $order, Request $request)
    {
        if (Auth::user()->is_admin == 1){
            $order->update($request->only('status'));
            $data['order'] =  $order;
            return $this->successResponse($order, 'Order Status Updated Successfully');
        }
        else{
            return $this->errorResponse('Unauthorized', 'Sorry you are not authorized to perform this action.');
        }
    }

    public function filterOrder(Request $request, Order $order)
    {
        $filter = $order->newQuery();

        if ($request->has('id')) {
            $filter->where('id', $request->id);
        }
        if ($request->has('status')) {
            $filter->where('status', $request->status);
        }
        return $this->successResponse($filter->get(), 'Product filtered Successfully', Response::HTTP_OK);
    }
}
