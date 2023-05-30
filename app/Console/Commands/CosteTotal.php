<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Order;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CosteTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coste:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Costo Total de las Ordenes';

    /**
     * Execute the console command.
     *
     * @return int
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
        $texto =  "[". date('Y-m-d H:i:s') ."] : Total Costo Ordenes => ".$total; 
        Log::info($texto);
        Storage::append("archivo.txt", $texto);
    }
}
