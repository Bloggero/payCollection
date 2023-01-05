@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary float-right">New User</button>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                         <b>Jose Luis</b>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <hr />
                        <p class="card-text text-danger"><b>$1600</b></p>

                    </div>

                    <a href="#" class="card-link bg-success"><div class="card-footer text-center">
                        Pay
                    </div>
                </a>
                </div>

            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                         <b>Jose Luis</b>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <hr />
                        <p class="card-text text-danger"><b>$1600</b></p>

                    </div>

                    <a href="#" class="card-link bg-success"><div class="card-footer text-center">
                        Pay
                    </div>
                </a>
                </div>

            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                         <b>Jose Luis</b>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <hr />
                        <p class="card-text text-danger"><b>$1600</b></p>

                    </div>

                    <a href="#" class="card-link bg-success"><div class="card-footer text-center">
                        Pay
                    </div>
                </a>
                </div>

            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
