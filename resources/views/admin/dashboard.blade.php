@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#newUserModal">New User</button>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <b>Jose Luis</b>
                        <label class="float-right"><i class="fa fa-eye" aria-hidden="true"></i></label>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the
                            bulk of the
                            card's content.</p>
                        <hr />
                        <p class="card-text text-danger"><b>$1600</b></p>

                    </div>

                    <a href="#" class="card-link bg-success">
                        <div class="card-footer text-center">
                            Pay
                        </div>
                    </a>
                </div>

            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <b>Jose Luis</b>
                        <label class="float-right"><i class="fa fa-eye" aria-hidden="true"></i></label>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the
                            bulk of the
                            card's content.</p>
                        <hr />
                        <p class="card-text text-danger"><b>$1600</b></p>

                    </div>

                    <a href="#" class="card-link bg-success">
                        <div class="card-footer text-center">
                            Pay
                        </div>
                    </a>
                </div>

            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <b>Jose Luis</b>
                        <label class="float-right"><i class="fa fa-eye" aria-hidden="true"></i></label>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the
                            bulk of the
                            card's content.</p>
                        <hr />
                        <p class="card-text text-danger"><b>$1600</b></p>

                    </div>

                    <a href="#" class="card-link bg-success">
                        <div class="card-footer text-center">
                            Pay
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>





    <!-- Modals -->
    <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">Add new user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="credit_type">Init</label>
                                <select name="credit_type" id="credit_type" class="form-control">
                                    <option value="from">From</option>
                                    <option value="to">To</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="date_info">Date</label>
                                <input type="date" name="date_info" id="date_info" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label for="time_type">Range</label>
                                <select name="time_type" id="time_type" class="form-control">
                                    <option value="week">Week</option>
                                    <option value="2weeks">2 Weeks</option>
                                    <option value="month">Month</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="extends_data">
                            <label class="form-check-label" for="extends">Extends?</label>
                        </div>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addBtn">ADD</button>
                </div>
            </div>
        </div>
    </div>
    @csrf
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@stop
