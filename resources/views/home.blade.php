@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
     <!--   <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                        
                    </div>
               </div>
        </div>
            </div>-->
            <div class="row justify-content-center py-4">
            <div class="card-body">
                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sno.</th>
                            <th>Order No.</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th class="center"><button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#createModal">
                                        Create
                                    </button></th>
                        </tr>
                    </thead>  
                    <tbody>  
                        <?php $i=1; ?>
                        @foreach($orders AS $key=>$order)
                        <tr>
                        <td>{{$i}}</td>
                        <td>{{$order->order_id}}</td>
                        <td>{{$order->customer_name}}</td>
                        <td>{{date("d-m-Y",strtotime($order->order_date))}}</td>
                        <td>{{$order->status}}</td>
                        <td>{{$order->total}}</td>
                        <td>
                            <button type="button" class="btn mr-2 mb-2 btn-warning edit" data-id="{{$order->id}}" data-toggle="modal" data-target="#updateModal">
                                Edit
                            </button>
                        </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>        
                    </table>
                </div>
         </div>

</div>

<!-- Start Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{Route('order.store')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="order_id"><span class="text-danger">*</span> Order ID</label>
                        <div class="position-relative form-group">
                            <input type="hidden" value="{{date('Y-m-d H:i:s')}}" name="order_date" />
                            <input name="order_id"  placeholder="order_id" type="text" class="form-control" value="{{date('YmdHis')}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="customer_name"><span class="text-danger">*</span> Customer Name</label>
                        <div class="position-relative form-group">
                            <input name="customer_name" placeholder="Customer Name here..." type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="order_id"><span class="text-danger">*</span> Status</label>
                        <div class="position-relative form-group">
                            <select class="multiselect-dropdown form-control" name="status">
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>                
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="status"><span class="text-danger">*</span> Total</label>
                        <div class="position-relative form-group">
                            <input name="total" placeholder="0.00" type="number" class="form-control" step=".01" min="0" max="99999999.99">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        `   </form>
        </div>
    </div>
</div>
<!-- End Create Modal -->


<!-- Start Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/order" method="post" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="order_id"><span class="text-danger">*</span> Order ID</label>
                        <div class="position-relative form-group">
                            <input name="order_id" id="order_id"  placeholder="order_id" type="text" class="form-control"  readonly>
                            <input type="hidden" id="id" name="id" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="customer_name"><span class="text-danger">*</span> Customer Name</label>
                        <div class="position-relative form-group">
                            <input name="customer_name" id="customer_name" placeholder="Customer Name here..." type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="status"><span class="text-danger" id="status">*</span> Status</label>
                        <div class="position-relative form-group">
                            <select class="multiselect-dropdown form-control" name="status" id="status">
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>                
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="total"><span class="text-danger">*</span> Total</label>
                        <div class="position-relative form-group">
                            <input id="total" name="total" placeholder="0.00" type="number" class="form-control" step=".01" min="0" max="99999999.99">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update changes</button>
            </div>
        `   </form>
        </div>
    </div>
</div>
<!-- End update Modal -->

<script>

    $(".edit").on("click",function(e){
        e.preventDefault();
        var id= $(this).data('id');
        console.log(id);
        $tr = $(this).closest('tr');
        var $data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        console.log($data);
        $("#order_id").val($data[1]);
        $("#customer_name").val($data[2]);
        $("#select2-status-container").attr('title',$data[4]);
        $("#select2-status-container").html($data[4]);
        $("#total").val($data[5]);
        $("#id").val(id);

        $('#editForm').attr("action","/order/"+id);
    });
</script>
@include('toastr')
@endsection
