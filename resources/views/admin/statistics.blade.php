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
        #alertToRecharge{
            display: none;
        }
    </style>
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 mb-2" id="optionBar">
                <div class="col-4 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                    <select name="year" id="year" class="form-control">
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
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
                    <div class="col-6 col-lg-3">

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>150</h3>
                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>53<sup style="font-size: 20px">%</sup></h3>
                                <p>Bounce Rate</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>44</h3>
                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>65</h3>
                                <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-2 mr-2 form-inline" id="addBar">

                <div class="form-group mx-sm-4 mb-2">
                    <label for="links" class="sr-only">Links</label>
                    <input type="number" class="form-control" id="links" placeholder="0.00">
                </div>
                <div class="form-group mx-sm-4 mb-2">
                    <label for="referals" class="sr-only">referals</label>
                    <input type="number" class="form-control" id="referals" placeholder="0.00">
                </div>
                <div class="form-group mx-sm-4 mb-2">
                    <label for="pop_ads" class="sr-only">Pop Ads</label>
                    <input type="number" class="form-control" id="pop_ads" placeholder="0.00">
                </div>
                <div class="form-group mx-sm-4 mb-2">
                    <label for="other_ads" class="sr-only">Other Ads</label>
                    <input type="number" class="form-control" id="other_ads" placeholder="0.00">
                </div>
                <div class="form-group mb-2">
                    <button type="buttom" class="btn btn-success mb-2" id="saveData">Save</button>
                </div>
                <div class="col-12" id="alertToRecharge">
                    <div class="alert alert-success" role="alert">
                        The data was successfully added, <strong><a href="javascript:void(0)" onclick="location.reload()">click here to see it</a></strong>.
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
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->count - $loop->iteration + 1 }}</td>
                                <td>${{ $item->links }}</td>
                                <td>${{ $item->referals }}</td>
                                <td>${{ $item->pop_ads }}</td>
                                <td>${{ $item->other_ads }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
