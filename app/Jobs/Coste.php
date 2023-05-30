<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\Order;

class Coste implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datas = Order::with(['costeSum' => function ($query) {
        
        }])->get();

            $total = 0;

            foreach($datas as $data){
                
                $total = $total + $data->costeSum->sum('pivot.count');
            }

            //return response()->json($total);
            echo "[". date('Y-m-d H:i:s') ."] Costo Total de las Ordenes => ". $total;
    }
}
