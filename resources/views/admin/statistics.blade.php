@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <p>Info cards</p>
            </div>
            <div class="col-12">
                <form class="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="links" class="sr-only">Links</label>
                        <input type="number" class="form-control" id="links" placeholder="Links">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="referals" class="sr-only">referals</label>
                        <input type="number" class="form-control" id="referals" placeholder="referals">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="pop_ads" class="sr-only">Pop Ads</label>
                        <input type="number" class="form-control" id="pop_ads" placeholder="pop_ads">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="other_ads" class="sr-only">Other Ads</label>
                        <input type="number" class="form-control" id="other_ads" placeholder="other_ads">
                    </div>
                    <button type="buttom" class="btn btn-success mb-2">Save</button>
                </form>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@stop
