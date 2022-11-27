@extends('layouts.frontend-main')

@section('content')

<section class="detail-section background-position-center" style="background:linear-gradient(360deg, #121212 0%, rgba(24, 24, 24, 0) 500%), url({{$playlist->image}}); background-position:top;background-size:cover">
    <div style="backdrop-filter:blur(5px);">
        <!-- <div class="mx-3"><span><a href="{{route('frontend.search')}}"><i class="fa-solid pe-2 fa-chevron-left"></i></a></span>My Playlists / {{$playlist->name}}</div> -->
        <div class="mx-3"><span><a href="{{url()->previous()}}"><i class="fa-solid pe-2 fa-chevron-left"></i></a></span>My Playlists / {{$playlist->name}}</div>
        <div class="container detail-container row my-5">
            <div class="col-md-9 col-sm-12 row">
                <div class="col-md-4 col-sm-12 justify-content-center d-block">
                    <div class="detail-img m-auto" style="border-radius:20px;box-shadow: 0px 15px 0px -10px rgb(255,255,255,0.3)">
                        <div class="position-relative w-100" style="padding-top:100% !important; box-shadow: 0px 30px 0px -20px rgb(255,255,255,0.3);border-radius: 30px;">
                            <img src="{{ $playlist->image }}" class="w-100 position-absolute" style="top:0px;left:0px; height:100%;object-fit:cover; border-radius:10px">
                        </div>
                        <span class="d-none img-src">{{$playlist->image}}</span>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 m-auto">
                    <span class="mobile-d-none">playlist</span>
                    <p class="h2 my-3" style="line-height:1.5">{{$playlist->name}}</p>
                    <div class="d-flex my-3 detail-info">
                        <div class="me-2 span"><i class="fa-solid fa-users mx-2"></i>Followers {{ $playlist->formatted_followers }} <span></span></div>
                        <div style="border-left:3px solid gray" class="span">
                            <i class="mx-2 fa-sharp fa-solid fa-calendar-week"></i>Tracks {{ $playlist->number_of_tracks }}
                        </div>
                    </div>
                    <span class="update_text">Updated:  <x-friendly-date :date="$playlist->last_updated_on"/></span>
                    <div class="d-flex mt-3 gap-3">
                        <span class="detail-icon" data-target="#reportPlaylistModal" data-toggle="modal" style="cursor:pointer"><i class="fa-solid fa-flag"></i></span>
                        <span class="detail-icon" style="cursor:pointer"><i class="fa-sharp fa-solid fa-share-nodes"></i></span>
                        <a onclick="ym(73260880, 'reachGoal', 'playonspotify'); return true;" id="spotifybtn" href="{{ $playlist->spotify_deep_link }}">
                            <button class="btn detail-button btn-primary rounded-pill"><i class="fa-brands fa-spotify"></i>Play On Spotify</button>
                        </a>            
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 container contact-detail d-flex flex-column justify-content-center">
                <div class="container h5">Contact Details</div>
                <div class="container h6">
                    <div class="my-3">
                        <span class="text-white"><i class="fa-solid fa-circle-user"></i></span> {{ $playlist->owner }}
                    </div>
                    <div class="my-3" style="overflow:inherit">
                        <span class="text-white"><i class="fa-solid fa-circle-envelope"></i></span> 
                            @foreach($playlist->contacts as $contact)
                                @if(filter_var($contact, FILTER_VALIDATE_EMAIL))
                                    {{ $contact }}
                                @else
                                    <a href="{{"https://www.instagram.com/" . substr($contact, 1) . "/" }}" target="_blank">
                                        {{"https://www.instagram.com/" . substr($contact, 1) . "/" }}
                                    </a>
                                @endif
                            @endforeach
                    </div>
                </div>
                <div class="text-center container">
                    <a onclick="ym(73260880, 'reachGoal', 'generatemessage'); return true;" id="generatemsgbtn" href="{{ route('frontend.message-generator', $playlist) }}">
                        <button class="detail-button w-100 btn btn-primary rounded-pill text-white"><i class="fa-solid fa-message-dots"></i>Generate Message</div>
                    </a>
            </div>
        </div>
    </div>
</section>

<section class="analyze-detail position-relative">
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6 col-sm-12 mt-3">
                <div class="container card gap-0 p-4 h-100">
                    <h5>Playlist Analysis</h5>
                    @foreach($playlist->moodiness as $mood => $value)
                        <div class="progress mb-3 position-lg-relative rounded-pill justify-content-between pe-3 d-flex align-items-center" 
                             style="height: 30px; background: #1b1b1b; box-shadow: 0px 0px 14px rgba(0, 0, 0, 0.25)" 
                             data-label="{{$playlist->moodValue($value)}} %"
                        >
                            <div class="progress-bar text-left ps-3" role="progressbar"
                                    style="width: {{$playlist->moodValue($value)}}%;overflow:initial; background:linear-gradient(90deg, #BE281D 0%, rgba(190, 40, 29, 0) 100%);border-bottom-left-radius:50em; border-top-left-radius:50em;"
                                    aria-valuenow="{{$playlist->moodValue($value)}}" aria-valuemin="0" aria-valuemax="100">
                                <span class="posit text-white">{{ ucfirst($mood) }}</span>
                            </div>
                            <span class="text-white">{{$playlist->moodValue($value)}}%<span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mt-3">
                <div class="container card gap-0 p-4">
                    <h5>Followers</h5>
                    <div><canvas id="followers_analyse" width="400" height="276"></canvas></div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mt-3">
                <div class="container card gap-0 p-4">
                    <h5>Top Genres</h5>
                    <div><canvas id="top_genres" width="400" height="400"></canvas></div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mt-3">
                <div class="container card gap-0 p-4 h-100">
                    <h5>Top Artists</h5>
                    <div id="top_artists" class="w-100 d-flex m-auto justify-content-center overflow-auto"></div>
                    <div class="analyse_badge">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="h2">Recommended For You</div>
        <div class="row">
            @include('frontend.includes.partials.gridlist',['playlists'=>$playlists])
        </div>
    </div>
</section>

@include('frontend.includes.modals.confirm_unlock')
@include('frontend.includes.modals.report_playlist', ['playlist'=>$playlist])

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script type="text/javascript" src="https://d3js.org/d3.v4.min.js"></script>
    <script>
        $(function(){
            $(".open-modal-grid").click(function (e) {
                var playlist_id = $(this).attr('data-playlist-id');
                $("input[name='playlist_id']").val(playlist_id);
                $(".playlist_unlock_detail img").attr('src', $("div[data-grid-id='"+playlist_id+"'] span.img-src").text());
                $(".playlist_unlock_detail #playlist_name").text($("div[data-grid-id='"+playlist_id+"'] span.name").text());
                $(".playlist_unlock_detail #playlist_followers").text($("div[data-grid-id='"+playlist_id+"'] span.followers").text());
                $(".playlist_unlock_detail #playlist_tracks").text($("div[data-grid-id='"+playlist_id+"'] span.tracks").text());
                $(".playlist_unlock_detail #playlist_updated").text($("div[data-grid-id='"+playlist_id+"'] span.updated").text());
            });
        });

        $(document).ready(function(){
            
            var followers = eval(<?php echo(json_encode($playlist->data))?>);
            var top_genres = eval(<?php echo(json_encode($playlist->genres))?>);
            var top_artists = eval(<?php echo(json_encode($playlist->top_artists))?>);

            var label_array = [], val_array = [], ctx;

            var data_array1=[], data_array2=[];

            for (let index = 0; index < followers['statistics']['followers'].length; index++) {
                var tempDate = new Date(Number(Object.values(followers['statistics']['followers'][index])[0])*1000);
                var tempArray = tempDate.toString().split(" ");
                label_array.push(tempArray[1]+" "+tempArray[2]);
                data_array1.push(Object.values(followers['statistics']['followers'][index])[1]);
            }

            ctx = document.getElementById('followers_analyse');

            var dataFirst = {
                label: "Followers",
                data: data_array1.reverse(),
                lineTension: 0,
                fill: false,
                borderColor: 'red'
            };

            var dataSecond = {
                label: "Tracks",
                data: data_array2,
                lineTension: 0,
                fill: false,
                borderColor: 'blue'
            };

            var speedData = {
                labels: label_array.reverse(),
                datasets: [dataFirst]
            };

            var chartOptions = {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                    boxWidth: 80,
                    fontColor: 'black'
                    }
                }
            };

            var lineChart = new Chart(ctx, {
                type: 'line',
                data: speedData,
                options: chartOptions
            });

            label_array = Object.keys(top_genres);
            val_array = Object.values(top_genres);
            keysSorted = Object.values(top_genres).sort(function(a,b){return top_genres[b]-top_genres[a]}).slice(0,10);
            label_array = label_array.sort(function(a,b){return b - a; }).slice(0,10);

            ctx = document.getElementById('top_genres');

            const myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: keysSorted,
                    datasets: [{
                        label: '# of Votes',
                        data: label_array,
                        backgroundColor: [
                            'rgba(255, 99, 132)',
                            'rgba(54, 162, 235)',
                            'rgba(255, 206, 86)',
                            'rgba(75, 192, 192)',
                            'rgba(153, 102, 255)',
                            'rgba(255, 159, 64)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    
                }
            });

            label_array = Object.keys(top_artists);
            val_array = Object.values(top_artists);

            label_array = Object.keys(top_artists).sort(function(a,b){return top_genres[b]-top_genres[a]}).slice(0,10);
            val_array = val_array.sort(function(a,b){return b - a; }).slice(0,10);
            
            var temp_array = [];

            for (let index = 0; index < val_array.length; index++) {

                var object = {Name:label_array[index], Count:val_array[index]};
                
                temp_array.push(object);
                
            }


            ctx = document.getElementById('top_artists');

            dataset = {
                "children": temp_array
            };

            var diameter = screen.width < 767 ? screen.width * 0.8 : 400;
            var color = d3.scaleOrdinal(d3.schemeCategory20);
            var html = "";

            var bubble = d3.pack(dataset)
                .size([diameter, diameter])
                .padding(1.5);

            var svg = d3.select("#top_artists")
                .append("svg")
                .attr("width", diameter)
                .attr("height", diameter)
                .attr("class", "bubble");

            var nodes = d3.hierarchy(dataset)
                .sum(function(d) { return d.Count; });

            var node = svg.selectAll(".node")
                .data(bubble(nodes).descendants())
                .enter()
                .filter(function(d){
                    return  !d.children
                })
                .append("g")
                .attr("class", "node")
                .attr("transform", function(d) {
                    return "translate(" + d.x + "," + d.y + ")";
                });

            node.append("title")
                .text(function(d) {
                    return d.data.Name + ": " + d.data.Count;
                });

            node.append("circle")
                .attr("r", function(d) {
                    return d.r;
                })
                .style("fill", function(d,i) {
                    return color(i);
                });

            node.append("text")
                .attr("dy", ".2em")
                .style("text-anchor", "middle")
                .text(function(d) {
                    return d.data.Name.substring(0, d.r / 3);
                })
                .attr("font-family", "sans-serif")
                .attr("font-size", function(d){
                    return d.r/5;
                })
                .attr("fill", "white");

            node.append("text")
                .attr("dy", "1.3em")
                .style("text-anchor", "middle")
                .text(function(d) {
                    return d.data.Count;
                })
                .attr("font-family",  "Gill Sans", "Gill Sans MT")
                .attr("font-size", function(d){
                    return d.r/5;
                })
                .attr("fill", "white");

            d3.select(self.frameElement)
                .style("height", diameter + "px");

            var html = "";
            for (let index = 0; index < label_array.length; index++) {
                 html += `<a class="hover-text-decoration-none"><span class="badge badge-soft-info cursor-pointer genre" style="background-color:`
                    +$('svg.bubble g:nth-child('+(index+1)+') circle').css("fill")
                    +`!important">`
                    +label_array[index]
                    +`</span></a>`;
            }

            $(".analyse_badge").append(html);
        }); 

    </script>

@endsection

<style>

    .detail-icon{
        width:40px;
        height:40px;
        border-radius:50%;
        color: #827F7F;
        background: #1b1b1b;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .detail-section{
        padding:3rem !important;
        padding-bottom: 200px !important;
    }

    .detail-info{
        font-size: 20px;
    }

    .detail-button{
        background: #1b1b1b !important;
        border: 1px gray solid !important;
        color: #5EFF5A !important;
        height:40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .contact-detail{
        border-left: 1px white solid;
    }

    span, .span{
        color: #C0C0C0;
    }

    span[data-toggle = "modal"]{
        display: inline!important;
        padding: 10px !important;
    }

    .analyze-detail{
        top:-200px;
    }

    @media screen and (max-width:767px){

        .detail-section{
            padding:0px  !important;
            text-align: center;
        }

        .update_text{
            font-size: 14px;
        }

        .detail-container{
            padding:0px !important;
        }

        .detail-img{
            width: 70% !important;
        }

        p.h2{
            font-size: 20px;
        }


        .detail-section .row{
            justify-content: center;
            margin: auto;
        }

        .detail-info{
            font-size: 16px;
            justify-content: center;
        }

        .contact-detail{
            margin-top: 35px !important;
            text-align: left;
            border: none;
            background: #1b1b1b;
            padding: 25px;
            border-radius: 20px;
        }

    }

</style>
