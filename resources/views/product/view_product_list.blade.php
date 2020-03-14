@extends('layouts.master')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-10">
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="box">
                    <div class="box-header box-header-title">
                        <h3 class="box-title">LIST OF Product</h3>
                        <a href="{{ route('productCreate') }}" class="btn btn-default pull-right"><i
                                    class="fa fa-plus-square"></i> ADD Product</a>
                    </div>

                     <section class="content">
            <!-- right column -->
            <div class="col-md-8 col-md-offset-1">
               
                <div class="row">
                    <div class="box box-info">
                       <form method="POST" action="" class="form-horizontal form-material m-t-30"  enctype="multipart/form-data" id="search-form">
                            <div class="box-body">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="product_name" class="col-sm-4 control-label">Product Name</label>
                                    <div class="col-sm-5">
                    <input type="text" class="form-control" id="product_name" name="product_name"
                                               placeholder="Enter Product Name">
                                      
                                    </div>
                                </div>
                                <div class="form-group">
                            <label for="parent_id" class="col-sm-4 control-label">Category Name</label>
                            <div class="col-sm-5"> 
                                       <select name="category_id" id="category_id" class="form-control" value="">
                                        <option value="">Select Category</option>
                                        @foreach ($category as $key=>$value)         
                                             <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                       
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="hidden" value="{{ Request::get('category_id') }}" name="report_category_id" /> 
                                <button type="reset" id="reset" class="btn btn-default">Clear</button>
                                <button type="submit" name="submit" class="btn btn-info pull-right">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
                    <div class="box-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Sort Order</th>
                                <th>ACTION</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@include('include.footer')

<script type="text/javascript"> 
        $(document).ready(function() {

     var oTable = $('#myTable').DataTable({
               lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                bFilter: false,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('productDatatable') }}",
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                   data: function (d) {
                        d.product_name = $('input[name=product_name]').val();
                        d.category_id = $('select[name=category_id]').val();
                        d.report_category_id = $('input[name=report_category_id]').val();                       
                    }
                }, 
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'category_id', name: 'category_id', orderable: true, searchable: false},
                    {data: 'product_name', name: 'product_name', searchable: false},
                    {data: 'price', name: 'price', orderable: true, searchable: false},
                    {data: 'sort_order', name: 'sort_order', searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

             $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
             });

              $('#reset').click( function (e) {
                oTable.ajax.reload();
                  $('input[name=product_name]').val('');
                  $('select[name=category_id]').val('');   
              });
        
         }); 
    </script>

@endsection