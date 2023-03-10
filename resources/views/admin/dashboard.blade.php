@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row" id="bigBox">
            <div class="col-12" id="divBtnNewUser">
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#newUserModal">New User</button>
            </div>
            <div class="col-12 mb-3" id="payDataDiv">
                <div class="row" id="payDataDivRow">
                    {{-- {{dd($payData)}} --}}
                    @if (count($payData) < 0)
                        <h1>No items to display yet.</h1>
                    @endif
                    @foreach ($payData as $element)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3" id="element-{{ $element->id }}">
                            <div class="card">
                                <div class="card-header">
                                    <b>{{ $element->username->name }}</b>
                                    {{-- <label class="float-right" data-toggle="modal" data-target="#showCardModal"><i class="fa fa-eye" --}}
                                    <label class="float-right"><i class="fa fa-eye showUser" aria-hidden="true"
                                            id="showUser-{{ $element->user_id }}"
                                            user="{{ $element->user_id }}"></i></label>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-muted">{{ $element->description }}</p>
                                    <hr />
                                    @if ($element->pay == 0)
                                        <p class="card-text text-danger" id="amount-{{ $element->id }}">
                                            <b>${{ $element->amount }}</b></p>
                                    @else
                                        <p class="card-text text-success"><b>${{ $element->amount }}</b></p>
                                    @endif
                                </div>
                                @if ($element->pay == 0)
                                    <a href="javascript:void(0)" class="card-link bg-success paynow"
                                        id="a-{{ $element->id }}">
                                    @else
                                        <a href="javascript:void(0)" class="card-link bg-secondary" disabled="true"
                                            style="pointer-events: none;">
                                @endif
                                <div class="card-footer text-center" collection="{{ $element->id }}"
                                    id="collection-{{ $element->id }}">Pay</div>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
                <hr>

            </div>
            <div class="col-12 pt-1" id="paidDataDiv">
                <div class="row"  id="paidDataDivRow">
                    @foreach ($paidData as $element)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3" id="element-${{ $element->id }}">
                            <div class="card">
                                <div class="card-header">
                                    <b>{{ $element->username->name }}</b>
                                    {{-- <label class="float-right" data-toggle="modal" data-target="#showCardModal"><i class="fa fa-eye" --}}
                                    <label class="float-right"><i class="fa fa-eye showUser" aria-hidden="true"
                                            id="showUser-{{ $element->user_id }}"
                                            user="{{ $element->user_id }}"></i></label>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-muted">{{ $element->description }}</p>
                                    <hr />
                                    @if ($element->pay == 0)
                                        <p class="card-text text-danger" id="amount-{{ $element->id }}">
                                            <b>${{ $element->amount }}</b></p>
                                    @else
                                        <p class="card-text text-success"><b>${{ $element->amount }}</b></p>
                                    @endif
                                </div>
                                @if ($element->pay == 0)
                                    <a href="javascript:void(0)" class="card-link bg-success paynow"
                                        id="a-{{ $element->id }}">
                                    @else
                                        <a href="javascript:void(0)" class="card-link bg-secondary" disabled="true"
                                            style="pointer-events: none;">
                                @endif
                                <div class="card-footer text-center" collection="{{ $element->id }}"
                                    id="collection-{{ $element->id }}">Pay</div>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- CardInfo -->
    <div class="modal fade" id="showCardModal" tabindex="-1" role="dialog" aria-labelledby="showCardModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showCardModalLabel">View Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body justify-content-center">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Paid</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="userCollectionsTable">
                        </tbody>
                    </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- AddUser -->
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
                        <div class="form-row">
                            <div class="form-group col-5">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group col-1">
                                <label style="color:white;">OR</label>
                                <label>OR</label>
                            </div>
                            <div class="form-group col-6">
                                <label for="name">Select</label>
                                <select name="selectUser" id="selectUser" class="form-control">
                                    <option value="nothing" selected>Select One</option>
                                    @foreach ($users as $element)
                                        <option value="{{ $element->id }}" forName="{{ $element->name }}">
                                            {{ $element->name . ' / ' . $element->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="description"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="date_info">Date</label>
                                <input type="date" name="date_info" id="date_info" class="form-control" value="">
                            </div>
                            <div class="form-group col-6">
                                <label for="time_type">Range</label>
                                <select name="time_type" id="time_type" class="form-control">
                                    <option value="justOnce">Just Once</option>
                                    <option value="week">Week</option>
                                    <option value="2weeks">2 Weeks</option>
                                    <option value="month">Month</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="0.00">
                        </div>
                        {{-- <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="extends_data">
                            <label class="form-check-label" for="extends_data">Extends?</label>
                        </div> --}}
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
