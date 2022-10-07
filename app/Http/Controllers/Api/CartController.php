<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Helpers\priceHelper;
use App\Models\Kitchen;
use App\Support\Cart\CartServices;
use App\Support\Cart\Events\ItemUpdated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Api\CartRequest;
use App\Http\Resources\KitchenResource;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
class CartController extends Controller
{
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository =$cartRepository;
    }
    public function location($request){
        if ($request['address_id']) $address = Address::findOrFail($request['address_id']);
        if ($request['kitchen_id']) $kitchen = Kitchen::findOrFail($request['kitchen_id']);
        try {
            $shipping_cost = priceHelper::deliveryDistance($kitchen->longitude,$kitchen->latitude,$address->longitude,$address->latitude);
        }catch (\Throwable $exception){
            throw ValidationException::withMessages(["message" => "cannot decide user location."]);
        }
        return $shipping_cost;
    }
    public function get()
    {
      
        request()->validate([
            'payment_method' => 'numeric|in:0,1',
            'address_id' => 'exists:addresses,id',
            'kitchen_id' => 'exists:kitchens,id',

        ]);
//        if(request()->address_id) $shipping_cost = $this->location(request()->all());
        $cartServices = app(CartServices::class);
        $cartServices = $cartServices
            ->setUser(auth('sanctum')->user())
            ->setIdentifier(request()->header('cart-identifier'))
            ->setKitchen(request()->kitchen_id)
            ->paymentMethod(request()->payment_method)
            ->shippingCost($shipping_cost ?? 0)
            ->getCart();
        return $cartServices;
    }
    public function addItem(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
            'kitchen_id' => 'required|exists:kitchens,id',
            'meal_id' => 'required|exists:meals,id'
        ]);

        $cartServices = app(CartServices::class);
        $cartServices
            ->setUser(auth('sanctum')->user())
            ->setIdentifier($request->header('cart-identifier'));
            //->setKitchen(request()->kitchen_id);
        $cart = $cartServices->getCart();
        if(is_null($cart->kitchen_id)) $cart->forceFill(['kitchen_id'=>$request->kitchen_id])->save();
        if(! Cart::where('identifier',$request->header('cart-identifier'))
            ->where('kitchen_id', $request->kitchen_id)
            ->first())
             throw ValidationException::withMessages(["message" => trans("carts.messages.diff_kitchen")]);
        $cartServices->addItem(
            $request->meal_id,
            $request->kitchen_id,
            $request->quantity,
        );

        return $cartServices->getCart();
    }


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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request, Cart $cart)
    {
        $request = $request->validated();
        if (isset($request['identifier'])){
            $exist_kitchen = Cart::where("identifier",$request['identifier'])->where("kitchen_id",$request['kitchen_id'])->exists();
            if(! $exist_kitchen) return response()->json(["message" => trans("carts.messages.diff_kitchen")],422);
        }

        if (! isset($request['identifier'])) {
            $request['identifier'] = $this->cartRepository->initialize_cart();
        }
        $cart = $this->cartRepository->store_cart($request, $cart);

        return $cart;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|string
     */
    public function show($identifier)
    {
        $cart = Cart::where('identifier', $identifier)->with('kitchen', 'meal')->get();
        if (sizeof($cart) == 0) {
            return response()->json(["message"=>trans('carts.messages.empty')], 404);
        }
//        return response()->json($cart);
        return CartResource::collection($cart);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function updateItem(CartItem $cartItem, Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);
        $cartItem->update($request->only('quantity'));

        $cartServices = app(CartServices::class);

        $cart = $cartServices
            ->setUser(auth('sanctum')->user())
            ->setIdentifier($request->header('cart-identifier'))
            ->getCart();
        $cartServices->shippingCost($cart->shipping_cost ?? 0)->updateTotals();

        broadcast(new ItemUpdated($cartItem))->toOthers();

        return $cart->refresh();
    }
    public function deleteItem(CartItem $cartItem, Request $request)
    {
        $cartItem->delete();
        $cartServices = app(CartServices::class);

        $cart = $cartServices
            ->setUser(auth('sanctum')->user())
            ->setIdentifier($request->header('cart-identifier'))
            ->getCart();
        $cartServices->shippingCost($cart->shipping_cost ?? 0)->updateTotals();
        if (! $cart->items()->exists()) $cart->update(['kitchen_id' => null]);
        if (! $cart->items()->exists()) $cart->delete();
        return $cart->refresh();
    }
    public function update(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'coupon' => 'nullable|exists:coupons,title'
        ]);
       

        $cartServices = app(CartServices::class);
        $distance = 0 ; // TODO: to remove
        $discount = 0;
        if ($value = $request->input('address_id')) {
            if (request()->address_id) $address = Address::findOrFail(request()->address_id);
            if (request()->kitchen_id) $kitchen = Kitchen::findOrFail(request()->kitchen_id);
            try {
                
            //    $distance = priceHelper::deliveryDistance($kitchen->longitude,$kitchen->latitude,$address->longitude,$address->latitude);
               $distance = 10;
    //        $cost = priceHelper::order_all_cost($distance, priceHelper::fixedDeliveryCost(), priceHelper::adminCommission() ,priceHelper::taxRatio(), priceHelper::additionalAddedTax());
           
                
              //   $array1 = [25,35,50];
              //  $distance = Arr::random($array1);
            }catch (\Throwable $exception){

                throw ValidationException::withMessages(["message" => "cannot decide user location."],422);
            }
        }

        if ($coupon_title = $request->input('coupon')) if ($coupon = Coupon::where('title', $coupon_title)->first()) $discount = $coupon->discount_percentage;
        $cart = $cartServices
            ->setUser(auth('sanctum')->user())
            ->setIdentifier($request->header('cart-identifier'))
            ->shippingCost(priceHelper::total($distance , $discount) ?? 0)
            ->updateTotals()
            ->getCart();
        $cart->forceFill(['address_id' => $value]);
        $cart->forceFill(['shipping_cost' => priceHelper::total($distance)]);

        if ($request->has('payment_method')) {
            $cart->forceFill(['payment_method' => $request->input('payment_method')]);
            $cart->payment_method =$request->input('payment_method');
            $cart->save();
        }
        if ($value = $request->input('notes')) {
            $cart->forceFill(['notes' => $value]);
        }

        if ($value = $request->input('coupon')) {
            $this->applyCoupon($value, $cart);
        }
        $cart->save();
        $cart = $cartServices
            ->setUser(auth('sanctum')->user())
            ->setIdentifier($request->header('cart-identifier'))
            ->updateTotals()
            ->getCart();

        return $cart;
    }
    protected function applyCoupon($coupon, Cart &$cart)
    {
        /** @var \App\Models\Coupon $coupon */
        if (! $coupon = Coupon::where('title', $coupon)->first()) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon you entered is invalid.')],
            ]);
        }
        if ($coupon->isExpired()) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon you entered is expired.')],
            ]);
        }

        if ($coupon->isused()) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon you entered is finshed.')],
            ]);
        }

        $cart->forceFill(['discount_percentage' => (float)$coupon->discount_percentage]);
        $cart->forceFill(['coupon_id' => $coupon->id]);

        return $this;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($identifier)
    {
        try {
            Cart::where('identifier',$identifier)->delete();
        }catch (\Throwable $exception){
            return response()->json(["message" => trans("carts.messages.delete")]);
        }
        return response()->json(["message" => trans("carts.messages.deleted")]);
    }
    public function remove($id)
    {
        try {
            Cart::find($id)->delete();
        }catch (\Throwable $exception){
            return response()->json(["message" => trans("carts.messages.delete")]);
        }
        return response()->json(["message" => trans("carts.messages.deleted")]);
    }


    public function coutitem(Request $request)
    {
      $cart = Cart::where('identifier',$request->identifier)->first();
      if($cart != null)
      {
        return response()->json(["count" => $cart->items->sum('quantity') ]);
      }
      else
      return response()->json(["count" => 0 ]);


    }
}
