<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderLine;

use App\Jobs\Coste;

class OrdersLinesComponent extends Component
{
    
    public $order_id, $product_id, $qty, $data1, $data2;

    public $orders;
    public $products;
    public $selectOrder = "";
    public $selectProduct = "";

    public function mount(){
        
        $this->orders = Order::pluck('order_ref','id')->all();
        $this->products = Product::pluck('name','id')->all();
    }

    public function render()
    {
        //$data = Order::with(['productos'])->get();
        $data = Order::all();
        
        Coste::dispatch();  
        //dd($orders);
        return view('livewire.orders-lines-component', ['data' => $data])->layout('livewire.layouts.base');
    }

    //on form submit validation
    public function store(){
        
        $this->validate([
            'selectOrder' => 'required',
            'selectProduct' => 'required',
            'qty' => 'required|numeric'
        ]);

        //Add
        $orderLine = new OrderLine();
        $orderLine->order_id = $this->selectOrder;
        $orderLine->product_id = $this->selectProduct;
        $orderLine->qty = $this->qty;

        $orderLine->save();

        //session()->flash('message','New Order line has been added successfully');
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Line Saved',
            'timer'=>3000,
            'icon'=>'success',
            'toast'=>true,
            'position'=>'top-right'
            ]);

        $this->selectOrder = "";
        $this->selectProduct = "";
        $this->qty = "";

        //For hide modal after add student success
        $this->dispatchBrowserEvent('close-modal');
    }

}
