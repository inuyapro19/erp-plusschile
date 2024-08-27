@extends('layouts.app')
@section('title','Inicio')
@push('styles')
    <script>
        (function(w,d,s,g,js,fs){
            g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
            js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
            js.src='https://apis.google.com/js/platform.js';
            fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
        }(window,document,'script'));
    </script>


    <script>

        gapi.analytics.ready(function() {

            /**
             * Authorize the user with an access token obtained server side.
             */
            gapi.analytics.auth.authorize({
                'serverAuth': {
                    'access_token': 'ya29.c.Ko4B3AdcnC0iON_dYELeyD0kdEQXgZ2mq1Uiqa1F7Lf2OQTFq3j88cOR3Qm7pc9fLze0gGJ1BgX5OO_FdFMt20-hhkPYlQBMSwOk9gzk-sn8dHlE7KUAErFmDntq9HRyuQIKG8WsNEc1GwIsB4_kBlsWgicEYtMgeeo3MI2RJc3U-xQqcRuVilWC85I3Sn-_xg'
                }
            });


            /**
             * Creates a new DataChart instance showing sessions over the past 30 days.
             * It will be rendered inside an element with the id "chart-1-container".
             */
            var dataChart1 = new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': 'ga:107973405', // <-- Replace with the ids value for your view.
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                    'metrics': 'ga:sessions,ga:users',
                    'dimensions': 'ga:date'
                },
                chart: {
                    'container': 'chart-1-container',
                    'type': 'LINE',
                    'options': {
                        'width': '100%'
                    }
                }
            });
            dataChart1.execute();


            /**
             * Creates a new DataChart instance showing top 5 most popular demos/tools
             * amongst returning users only.
             * It will be rendered inside an element with the id "chart-3-container".
             */
            var dataChart2 = new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': 'ga:107973405', // <-- Replace with the ids value for your view.
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                    'metrics': 'ga:sessions',
                    'dimensions': 'ga:pagePathLevel1',

                    'filters': 'ga:pagePathLevel1!=/',
                    'max-results': 7
                },
                chart: {
                    'container': 'chart-2-container',
                    'type': 'PIE',
                    'options': {
                        'width': '100%',
                        'pieHole': 4/9,
                    }
                }
            });
            dataChart2.execute();

            console.log(dataChart2);

        });
    </script>

@endpush
@section('content')
<div class="container">
    <div class="row">
        <h2 class="mb-5">BIENVENIDO {{Auth::user()->name}}</h2>
        <div class="col-md-12">
            <div id="chart-1-container"></div>
            <div id="chart-2-container"></div>
        </div>
    </div>
</div>
@endsection
