@extends('layouts.master')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-11">
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="box">
                    <div class="box-header box-header-title">
                        <h3 class="box-title">LIST OF ADDRESS BOOK</h3>
                        <a href="{{ route('user.create') }}" class="btn btn-default pull-right"><i
                                    class="fa fa-plus-square"></i> ADD ADDRESS BOOK</a>
                    </div>
                    <div class="box-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Profile Pic</th>
                                <th>Email</th>
                                <th>Street</th>
                                <th>Zip Code</th>
                                <th>City</th>
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
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'JSON',
                        action: function ( e, dt, button, config ) {
                            var data = dt.buttons.exportData();
         
                            $.fn.dataTable.fileSave(
                                new Blob( [ JSON.stringify( data ) ] ),
                                'Export.json'
                            );
                        }
                    },
                ],
                bFilter: false,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('userDatatable') }}",
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                }, 
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'profile_pic', name: 'profile_pic',orderable: false, searchable: false},
                    {data: 'email', name: 'email'},
                    {data: 'street', name: 'street'},
                    {data: 'zip_code', name: 'zip_code'},
                    {data: 'city', name: 'city'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });
        
         }); 
    </script>

@endsection