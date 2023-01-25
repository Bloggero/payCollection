@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <style>
        #optionBar {
            display: flex;
            flex-wrap: wrap;
            justify-content: end;
            margin-bottom: 0.5rem;
        }

        #alertToRecharge {
            display: none;
        }
    </style>
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 mb-2" id="optionBar">
                <div class="col-4 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                    <select name="year" id="year" class="form-control">
                        @for ($firstYear = $firstYear; $firstYear <= $lastYear; $firstYear++)
                            @if ($firstYear == $lastYear)
                                <option value="{{ $firstYear }}" selected>{{ $firstYear }}</option>
                            @else
                                <option value="{{ $firstYear }}">{{ $firstYear }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="col-4 col-md-3 col-lg-2">
                    <select name="month" id="month" class="form-control">
                    </select>
                </div>
                <div class="col-3 col-md-2 col-xl-1">
                    <button name="getData" id="getData" class="btn btn-primary">Get Data</button>
                </div>
            </div>

            <div class="col-12 mb-2" id="infoBar">
                <div class="row">
                    <div class="col-6 col-lg-4">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><sup style="font-size: 20px">$</sup><span id="expenses"
                                        val="{{ $expenses }}">{{ $expenses }}</span></h3>
                                <p>Last Month: <span id="lastExpenses">${{ $lastExpenses }}</span></p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-arrow-circle-down"></i>
                            </div>
                            <a href="#" class="small-box-footer">Expenses</a>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><sup style="font-size: 20px">$</sup><span id="revenue"
                                        val="{{ $revenue }}">{{ $revenue }}</span></h3>
                                <p>Last Month: <span id="lastRevenue">${{ $lastRevenue }}</span></p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-arrow-circle-up"></i>
                            </div>
                            <a href="#" class="small-box-footer">Revenue</a>
                        </div>
                    </div>



                    <div class="col-12 col-lg-4">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><sup style="font-size: 20px">$</sup><span id="earnings"
                                        val="{{ $revenue - $expenses }}">{{ $revenue - $expenses }}</span></h3>
                                <p>Last Month: <span id="lastEarnings">${{ $lastRevenue - $lastExpenses }}</span></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                            <a href="#" class="small-box-footer">Earnings</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 mb-2 mr-2 form-inline" id="addBar">

                <div class="form-group mx-sm-4 mb-2">
                    <label for="links" class="mr-1">Links</label>
                    <input type="number" class="form-control" id="links" placeholder="0.00">
                </div>
                <div class="form-group mx-sm-4 mb-2">
                    <label for="referals" class="mr-1">Referals</label>
                    <input type="number" class="form-control" id="referals" placeholder="0.00">
                </div>
                <div class="form-group mx-sm-4 mb-2">
                    <label for="pop_ads" class="mr-1">Pop Ads</label>
                    <input type="number" class="form-control" id="pop_ads" placeholder="0.00">
                </div>
                <div class="form-group mx-sm-4 mb-2">
                    <label for="other_ads" class="mr-1">Other Ads</label>
                    <input type="number" class="form-control" id="other_ads" placeholder="0.00">
                </div>
                <div class="form-group mx-sm-4 mb-2">
                    <input class="form-check-input" type="checkbox" value="" id="clearInputs">
                    <label class="form-check-label" for="clearInputs">Clear Inputs</label>
                </div>
                <div class="form-group mb-2">
                    <button type="buttom" class="btn btn-success mb-2" id="saveData">Save</button>
                </div>
                <div class="col-12" id="alertToRecharge">
                    <div class="alert alert-success" role="alert">
                        The data was successfully added, <strong><a href="javascript:void(0)"
                                onclick="location.reload()">click here to see it</a></strong>.
                    </div>
                </div>
            </div>

            <div class="col-12 mb-2" id="informationTable">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Day</th>
                            <th scope="col">Links</th>
                            <th scope="col">Referals</th>
                            <th scope="col">Pop Ads</th>
                            <th scope="col">Others</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($items as $item)
                            <tr id="tr-{{ $item->id }}">
                                <td>{{ $loop->count - $loop->iteration + 1 }}</td>
                                <td>${{ $item->links }}</td>
                                <td>${{ $item->referals }}</td>
                                <td>${{ $item->pop_ads }}</td>
                                <td>${{ $item->other_ads }}</td>
                                <td><button class="btn btn-primary btnToEdit" 
                                    collection="{{ $item->id }}"
                                    links="{{ $item->links }}"
                                    referals="{{ $item->referals }}"
                                    pop_ads="{{ $item->pop_ads }}"
                                    other_ads="{{ $item->other_ads }}"
                                    day="{{ $loop->count - $loop->iteration + 1 }}"
                                    >Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mx-sm-4 mb-2">
                        <label for="editLinks" class="mr-1">Links</label>
                        <input type="number" class="form-control" id="editLinks" placeholder="0.00">
                    </div>
                    <div class="form-group mx-sm-4 mb-2">
                        <label for="editReferals" class="mr-1">Referals</label>
                        <input type="number" class="form-control" id="editReferals" placeholder="0.00">
                    </div>
                    <div class="form-group mx-sm-4 mb-2">
                        <label for="editPop_ads" class="mr-1">Pop Ads</label>
                        <input type="number" class="form-control" id="editPop_ads" placeholder="0.00">
                    </div>
                    <div class="form-group mx-sm-4 mb-2">
                        <label for="editOther_ads" class="mr-1">Other Ads</label>
                        <input type="number" class="form-control" id="editOther_ads" placeholder="0.00">
                    </div>
                    <input type="hidden" id="editId" value="0">
                    <input type="hidden" id="editDay" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnUpdate">Update</button>
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
    <script>
        let countItems =
        {{ $items->count() }}; /*this is for count numbers of the items and next get the last number of the table*/
    </script>
    <script src="{{ asset('js/statistics.js') }}"></script>
@stop
