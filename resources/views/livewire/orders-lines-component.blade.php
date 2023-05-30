<div>
<div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3><strong>Laravel Livewire Beeping</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="float: left;"><strong>Orders Lines</strong></h5>
                        <button class="btn btn-sm btn-secondary" style="float: right;" data-toggle="modal" data-target="#addOrderLineModal">Add New Order Line</button>
                    </div>
                        <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message') }}</div>
                        @endif

                        <table id="tablaorders" class="table table-bordered display responsive nowrap shadow-lg" style="width: 100%;">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <!--<th>ID</th>-->
                                    <th>Order Ref.</th>
                                    <th>Customer Name</th>
                                    <th>Total QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->count() > 0)
                                    @foreach ($data as $order)
                                        <tr>
                                            <td>{{ $order->order_ref }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->productos->sum('pivot.qty') }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>                        
                        <!--<table class="table table-bordered shadow-lg">
                            <thead>
                                <tr>
                                    <th>Order Ref.</th>
                                    <th>QTY</th>
                                    <th>Coste</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->count() > 0)
                                    @foreach ($data as $order)
                                        <tr>
                                            <td>{{ $order->order_ref }}</td>
                                            <div style="display:none">@php($qty = 0)</div>
                                            <div style="display:none">@php($coste = 0)</div>
                                            @foreach($order->productos as $item)
                                            <div style="display:none">{{ $qty = $qty + $item->pivot->qty }}</div>
                                            <div style="display:none">{{ $coste = $coste + ($item->pivot->qty * $item->cost) }}</div>
                                            @endforeach
                                            <td>{{ $qty }}</td>
                                            <td>{{ $coste }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center;"><small>No Orders Found</small></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addOrderLineModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Line</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group row">
                            <label for="order_id" class="col-3">Order</label>
                            <div class="col-9">
                                <select class="form-control" wire:model="selectOrder">
                                        <option value="">Seleccione...</option>
                                    @foreach($orders as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('selectOrder')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_id" class="col-3">Product</label>
                            <div class="col-9">
                                <select class="form-control" wire:model="selectProduct">
                                        <option value="">Seleccione...</option>
                                    @foreach($products as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('selectProduct')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="qty" class="col-3">Qty</label>
                            <div class="col-9">
                                <input type="number" id="qty" class="form-control" wire:model="qty">
                                @error('qty')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Add Line</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready( function () {
            $('#tablaorders').DataTable({
            responsive:true
             });
        });

        window.addEventListener('close-modal', event =>{
            $('#addOrderLineModal').modal('hide');
        });

        window.addEventListener('swal',function(e){
        Swal.fire(e.detail);
        
        /*setTimeout(function(){
            window.location.reload();
        }, 2000);*/
    });
    </script>
@endpush
