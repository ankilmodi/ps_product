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
                        <h3 class="box-title">LIST OF Category</h3>
                        <a href="{{ route('categoryCreate') }}" class="btn btn-default pull-right"><i
                                    class="fa fa-plus-square"></i> ADD Category</a>
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
                                    <label for="category_name" class="col-sm-4 control-label">Category Name</label>
                                    <div class="col-sm-5">
                    <input type="text" class="form-control" id="category_name" name="category_name"
                                               placeholder="Enter Category Name">
                                      
                                    </div>
                                </div>
                                <div class="form-group">
                            <label for="parent_id" class="col-sm-4 control-label">Parent Category Name</label>
                            <div class="col-sm-5"> 
                                       <select name="parent_id" id="parent_id" class="form-control" value="">
                                        <option value="">Select Parent Category</option>
                                        @foreach ($category as $key=>$value)         
                                             <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                       
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
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
                                <th>Category Name</th>
                                <th>Parent Category</th>
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

    var oTable =    $('#myTable').DataTable({
               lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
                bFilter: false,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('categoryDatatable') }}",
                    headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    type : "POST",
                    data: function (d) {
                        d.category_name = $('input[name=category_name]').val();
                        d.parent_id = $('select[name=parent_id]').val();                       
                    }
                }, 
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'category_name', name: 'category_name', orderable: true, searchable: false},
                    {data: 'parent_id', name: 'parent_id', searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [ 0, "desc" ],
            });

             $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
             });

               $('#reset').click( function (e) {     
                  $('input[name=product_name]').val('');
                  $('select[name=category_id]').val('');   
                    oTable.ajax.reload();
              });
        
         }); 


    </script>

@endsection