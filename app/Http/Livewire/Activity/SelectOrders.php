<?php

namespace App\Http\Livewire\Activity;

use Livewire\Component;

use App\Models\Order;

class SelectOrders extends Component
{
    public $search = '';
    public $ordersArray = array();
    public $active = true;

    public function render()
    {
        return view('livewire.activity.select-orders',[
            'orders' => Order::where('closed', 0)->where( function($query) {
                $query->where('reference', 'LIKE', "%{$this->search}%")->orWhere('id', 'LIKE', "%{$this->search}%");
                // ->orWhere('lastname', 'LIKE', "%{$this->search}%");
            })->orderBy('created_at','desc')->get()
        ]);
    }

    public function addOrderToActivity($id, $reference){
        // dd(array_search($id, array_column($this->ordersArray, 'id')));
        if(array_search($id, array_column($this->ordersArray, 'id')) === false){
            array_push($this->ordersArray, array('id'=> $id, 'reference' => $reference));
        }
    }

    public function removeOrderToActivity($id){
        $secuence = array_search($id, array_column($this->ordersArray, 'id'));
        if($secuence !== null){
            unset($this->ordersArray[$secuence]);
        }
    }
}
