<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function productos(){
            
        return $this->belongsToMany('\App\Models\Product', 'orders_lines')->withPivot('qty');
    }

    public function costeSum(){
        
        return $this->belongsToMany('\App\Models\Product', 'orders_lines')
        ->selectRaw('sum(orders_lines.qty * products.cost) as pivot_count')
        //->withTimestamps()
        ->groupBy('pivot_product_id','pivot_order_id');
    }
}
