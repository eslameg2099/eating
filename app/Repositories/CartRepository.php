<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Meal;

class CartRepository
{
    /**
     * The order instance.
     *
     * @var \App\Models\Meal
     */
    protected $meal;

    public function __construct()
    {
        
    }

    /**
     * Set the order instance.
     *
     * @param \App\Models\Meal $meal
     */
    public function setMeal($meal_id)
    {
        $meal = Meal::findOrFail($meal_id);

        return $meal;
    }

    /**
     * initialize a newly cart resource in storage.
     *
     * @return \Illuminate\Http\Response $identifier
     */
    public function initialize_cart()
    {
        return uniqid();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    public function store_cart($request, $cart)
    {
        $meal = $this->setMeal($request['meal_id']);
        $request['main_cost'] = is_null($meal['cost_after_discount']) ? $meal['cost'] : $meal['cost_after_discount'];
        $request['cost'] = $this->calculate_cost($meal->cost, $request['quantity']);
        if (! is_null($meal['cost_after_discount'])) {
            $request['cost_after_discount'] =  $this->calculate_discount($meal['cost_after_discount'], $request['quantity']);
        }

        return $cart->create($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    public function update_cart($identifier, $data)
    {
        $meal = $this->setMeal($data['meal_id']);
        $data['cost'] = $this->calculate_cost($meal['cost'], $data['quantity']);
        if (! is_null($meal['cost_after_discount'])) {
            $data['cost_after_discount'] =  $this->calculate_discount($meal['cost_after_discount'], $data['quantity']);
        }
        $cart = Cart::where('identifier', $identifier)->where('meal_id', $data['meal_id'])->with('kitchen', 'meal');
//        if(!isset($data['quantity'])) $data['quantity'] = $this->increase_item($cart['quantity']);
        $cart->update($data);

        return $cart->get();
    }

    private function calculate_discount($cost, $quantity)
    {
        return $cost * $quantity ;
    }

    private function calculate_cost($cost, $quantity)
    {
        return $cost * $quantity ;
    }

    private function increase_item($quantity)
    {
        return $quantity++ ;
    }

//     TODO:: Refactor get_cart , get_meal -> instances
}
