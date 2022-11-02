@extends('backend.layouts.master')

@section('title', 'Playlists')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Playlists Crawler</a>
@endsection



@section('breadcrumb-active', 'Playlists Statistics')

@section('content')
<h3 class="mt-4">Playlists daily average for the past 2 months: {{$totalPlaylists2Months}}</h3>

<h2 class="text-center mt-4">Playlists by months</h2>
<div style="height: 500px">
    <canvas id="playlists-chart"></canvas>
</div>
<h2 class="text-center mt-4">Playlists by days(Last 2 months)</h2>
<div style="height: 500px">
    <canvas id="playlists-chart-day"></canvas>
</div>
@endsection




@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script>

    var ctx = document.getElementById('playlists-chart').getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
            data: {
            labels:  {!! json_encode($xAxis, JSON_HEX_TAG) !!},
                    datasets: [{
                    label: 'Playlists',
                            data: {!! json_encode($yAxis, JSON_HEX_TAG) !!},
                            backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                    'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1
                    }]
            },
            options: {
            responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                    y: {
                    beginAtZero: true
                    }
                    }
            }
    });
    
    
    var ctxDay = document.getElementById('playlists-chart-day').getContext('2d');
    var playlistChartDay = new Chart(ctxDay, {
    type: 'line',
            data: {
            labels:  {!! json_encode($xAxisDay, JSON_HEX_TAG) !!},
                    datasets: [{
                    label: 'Playlists',
                            data: {!! json_encode($yAxisDay, JSON_HEX_TAG) !!},
                            backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                    'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1
                    }]
            },
            options: {
            responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                    y: {
                    beginAtZero: true
                    }
                    }
            }
    });
</script>




@endsection

