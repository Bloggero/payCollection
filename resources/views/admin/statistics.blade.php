@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
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

            <div class="col-12 mb-2" id="addBar">
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
            <div class="col-12 mb-2 mr-2 form-inline" id="optionBar" style="justify-content: flex-end">
                <select name="year" id="year" class="col-1 form-control mx-sm-3">
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                </select>
                <select name="month" id="month" class="col-3 form-control mx-sm-1">
                </select>
                <button  name="getData" id="getData" class="btn btn-primary mx-sm-1">Get Data</button>
            </div>
            <div class="col-12 mb-2" id="informationTable">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Links</th>
                            <th scope="col">Referals</th>
                            <th scope="col">Pop Ads</th>
                            <th scope="col">Others</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>Otto</td>
                            <td>Otto</td>
                        </tr>

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
    <script src="{{ asset('js/statistics.js') }}"></script>
@stop
