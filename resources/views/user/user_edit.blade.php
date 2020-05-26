@extends('layouts.master')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
           
            <ol class="breadcrumb" align="center">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Edit Address Book</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- right column -->
            <div class="col-md-8 col-md-offset-1">
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="row">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Update</h3>
                        </div>
                        <form class="form-horizontal" action="{{ route('user.update',$user->id) }}" method="post" enctype="multipart/form-data" data-parsley-validat >
                            <div class="box-body">
                                @csrf
                                @method('PUT')
                        <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                                    <label for="first_name" class="col-sm-4 control-label">First Name</label>
                                    <div class="col-sm-5">
                            <input type="text" class="form-control" value="{{ $user->first_name }}" id="first_name" name="first_name" placeholder="Enter First Name">
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                
                              <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="last_name" class="col-sm-4 control-label">Last Name</label>
                                    <div class="col-sm-5">
                            <input type="text" class="form-control" id="last_name" name=" last_name" value="{{ $user->last_name }}" placeholder="Enter Last Name">
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                             <div class="form-group{{ $errors->has('profile_pic') ? ' has-error' : '' }}">
                                    <label for="profile_pic" class="col-sm-4 control-label">Profile Image</label>
                                    <div class="col-sm-5">
                            <input type="file" class="form-control" id="profile_pic" name="profile_pic">

                             <input type="hidden" class="form-control" id="old_image" name="old_image" value="{{ $user->profile_pic }}">

                                        @if ($errors->has('profile_pic'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('profile_pic') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>  


                               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $user->email }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>  

                                <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                                    <label for="street" class="col-sm-4 control-label">Street </label>
                                    <div class="col-sm-5">
                            <textarea class="form-control" id="street" name="street" placeholder="Enter Street" >{{ $user->street }}</textarea>
                                        @if ($errors->has('street'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>         
                                   

                             <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                                    <label for="zip_code" class="col-sm-4 control-label">Zip Code </label>
                                    <div class="col-sm-5">
                            <input type="text" class="form-control" id="zip_code" name="zip_code"
                                               placeholder="Enter Zip Code" value="{{ $user->zip_code }}">
                                        @if ($errors->has('zip_code'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('zip_code') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>               
                               

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city " class="col-sm-4 control-label">City</label>
                            <div class="col-sm-5"> 
                                    <select name="city" class="form-control itemName" value=""> 
                                        @foreach ($city as $key=>$value)         
                                            <option value="{{  $value }}" {{ $user->city == $value ? "selected" : "" }}>{{ $value }}</option>
                                        @endforeach
                                       </select>
                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Clear</button>
                                <button type="submit" name="submit" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('include.footer')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script type="text/javascript">

      $('.itemName').select2({
        placeholder: 'Select an item', 
        ajax: {
          type: "POST",
          headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
          url: '{{ route('cityList') }}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.name
                    }
                })
            };
          },
          cache: true
        }
      });
</script>
  
@endsection