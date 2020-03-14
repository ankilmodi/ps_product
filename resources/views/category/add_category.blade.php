@extends('layouts.master')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
           
            <ol class="breadcrumb" align="center">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">add Category</li>
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
                            <h3 class="box-title">ADD Category</h3>
                        </div>
                        <form class="form-horizontal" action="{{ route('categoryStore') }}" method="post" data-parsley-validate>
                            <div class="box-body">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('category_name') ? ' has-error' : '' }}">
                                    <label for="category_name" class="col-sm-4 control-label">Category Name</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="category_name" name=" category_name"
                                               placeholder="Enter Category Name">
                                        @if ($errors->has('category_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('category_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                            <label for="parent_id" class="col-sm-4 control-label">Parent Category Name</label>
                            <div class="col-sm-5"> 
                                       <select name="parent_id" class="form-control" value="">
                                        <option value="">Select Parent Category</option>
                                        @foreach ($category as $key=>$value)         
                                             <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                       
                                       </select>
                                        @if ($errors->has('parent_id'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('parent_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Clear</button>
                                <button type="submit" name="submit" class="btn btn-info pull-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection