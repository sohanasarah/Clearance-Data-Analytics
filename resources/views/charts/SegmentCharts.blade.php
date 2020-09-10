@extends('layouts.master')

@section('content-title')
Segment Contribution
@endsection

@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card card-outline card-cyan">
                    <div class="card-body">
                        {{-- filter card --}}
                        <div class="card card-solid card-body bg-light pb-0">
                            <form class="form inline">
                                <div class="form-row">

                                    <div class="form-group col-md-2">
                                        <div class="card card-body bg-lightblue">
                                            <label for="">Calendar Type</label>
                                            <div class="form-check">
                                                <input class="form-check-input input-sm" type="radio"
                                                    name="calendar_type" value="fiscal_year">
                                                <label class="form-check-label">Fiscal Year</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input input-sm" type="radio"
                                                    name="calendar_type" value="calendar_year" checked>
                                                <label class="form-check-label">Calendar Year</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <div class="card card-body bg-lightblue">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Base Year</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Current Year</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Year</div>
                                                        </div>
                                                        <select class="custom-select" name="base_year" id="base_year">
                                                            @foreach ($calendar->unique('calendar_year') as
                                                            $calendar_data)
                                                            <option value="{{ $calendar_data->calendar_year }}">
                                                                {{ $calendar_data->calendar_year }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Month</div>
                                                        </div>
                                                        <select class="custom-select" name="base_period_from" id="base_period_from">
                                                            @foreach ($calendar->unique('calendar_period') as $calendar_data)
                                                            <option value="{{ $calendar_data->calendar_period }}">
                                                                {{ $calendar_data->calendar_period }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <select class="custom-select" name="base_period_to" id="base_period_to">
                                                            @foreach ($calendar->unique('calendar_period') as $calendar_data)
                                                            <option value="{{ $calendar_data->calendar_period }}">
                                                                {{ $calendar_data->calendar_period }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Year</div>
                                                        </div>
                                                        <select class="custom-select" name="current_year" id="current_year">
                                                            @foreach ($calendar->unique('calendar_year') as $calendar_data)
                                                            <option value="{{ $calendar_data->calendar_year }}">
                                                                {{ $calendar_data->calendar_year }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Month</div>
                                                        </div>
                                                        <select class="custom-select" name="current_period_from" id= "current_period_from">
                                                            @foreach ($calendar->unique('calendar_period') as $calendar_data)
                                                            <option value="{{ $calendar_data->calendar_period }}">
                                                                {{ $calendar_data->calendar_period }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <select class="custom-select" name="current_period_to" id="current_period_to">
                                                            @foreach ($calendar->unique('calendar_period') as $calendar_data)
                                                            <option value="{{ $calendar_data->calendar_period }}">
                                                                {{ $calendar_data->calendar_period }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="card card-body bg-lightblue">
                                            <div class="row">
                                                <label for="">Measure</label>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Measure</div>
                                                    </div>
                                                    <select class="custom-select" name="measure">
                                                        {{-- <option selected disabled>Select Measure</option> --}}
                                                        @foreach ($codes as $code)
                                                        <option value="{{ $code->code_value }}">{{ $code->code_value }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1 mt-4 pt-4">
                                        <button class="btn btn-block btn-success" type="submit">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div id="chart1" style="border: 1px solid #ccc;"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="chart2" style="border: 1px solid #ccc;"></div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
</div>


@endsection

@section('page-script')

<script type="text/javascript">

    $('input[name=calendar_type]').change(function(){

        var value = $( 'input[name=calendar_type]:checked' ).val();

        if(value === 'fiscal_year'){
            var fiscal_year_options = [];
            var fiscal_period_options = [];
            var fiscal_year_obj   = {!! $calendar->unique('fiscal_year') !!};
            var fiscal_period_obj = {!! $calendar->unique('fiscal_period') !!};
            
            $.each(fiscal_year_obj, function(key, value) {
                //console.log(value.fiscal_year);
                fiscal_year_options.push(value.fiscal_year);
            });

            $.each(fiscal_period_obj, function(key, value) {
                fiscal_period_options.push(value.fiscal_period);
            });

            changeOptions( $('#base_year'), fiscal_year_options);
            changeOptions( $('#base_period_from'), fiscal_period_options);
            changeOptions( $('#base_period_to'), fiscal_period_options);

            changeOptions( $('#current_year'), fiscal_year_options);
            changeOptions( $('#current_period_from'), fiscal_period_options);
            changeOptions( $('#current_period_to'), fiscal_period_options);
        }
        else{
            var calendar_year_options = [];
            var calendar_period_options = [];
            var calendar_year_obj  = {!! $calendar->unique('calendar_year') !!};
            var calendar_period_obj = {!! $calendar->unique('calendar_period') !!};
            
            $.each(calendar_year_obj, function(key, value) {
                calendar_year_options.push(value.calendar_year);
            });

            $.each(calendar_period_obj, function(key, value) {
                calendar_period_options.push(value.calendar_period);
            });

            changeOptions( $('#base_year'), calendar_year_options);
            changeOptions( $('#base_period_from'), calendar_period_options);
            changeOptions( $('#base_period_to'), calendar_period_options);

            changeOptions( $('#current_year'), calendar_year_options);
            changeOptions( $('#current_period_from'), calendar_period_options);
            changeOptions( $('#current_period_to'), calendar_period_options);
        }
    });

    function changeOptions($el, newOptions){
        var prevValue = $el.val();
        $el.empty();
        $.each(newOptions, function(key, value) {
            $el.append($('<option></option>').attr('value', value).text(value));
            if (value === prevValue){
                $el.val(value);
            }
        });
        $el.trigger('change');
    }

    var base_data = '';
    var current_data = '';

    base_data = {!! $base_data !!};
    current_data = {!! $current_data !!};
    console.log(base_data);

    // Load Charts and the corechart package.
    google.charts.load("current", {packages:["corechart"]});

    google.charts.setOnLoadCallback(drawBaseChart);
    google.charts.setOnLoadCallback(drawCurrChart);

    function drawBaseChart() {
        var data = google.visualization.arrayToDataTable(base_data);

        var options = {
            title: '2018 (Jan to Dec)',
            is3D: true,
            width: 450,
            height: 400,
            chartArea:{ left:50, top:50, width:'100%',height:'70%'},
            legend: { position: 'bottom', textStyle: {color: 'blue'} },
            pieSliceText: 'value-and-percentage',
            pieSliceTextStyle: { color: 'white', fontSize: '14' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart1'));
        chart.draw(data, options);
    }

    function drawCurrChart() {
        var data = google.visualization.arrayToDataTable(current_data);

        var options = {
            title: '2019 (Jan to Jun)',
            is3D: true,
            width:450,
            height:400,
            chartArea:{ left:50,top:50, width:'100%',height:'70%'},
            legend: { position: 'bottom', textStyle: {color: 'blue'} },
            pieSliceText: 'value-and-percentage',
            pieSliceTextStyle: { color: 'white', fontSize: '14' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart2'));
        chart.draw(data, options);
    }


</script>
@endsection