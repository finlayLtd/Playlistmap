<!-- Modal -->
<div class="modal fade" id="pld_{{ $playlist->id }}_modal" tabindex="-1" aria-labelledby="pld_{{ $playlist->id }}_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 right-0 mt-3 mr-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body p-0">
                <div class="bg-card-gradient rounded-top-lg py-3 pl-4 pr-6">
                    <h4 class="mb-1 text-white playlist-name p-4" id="staticBackdropLabel">{{ $playlist->name }}</h4>
                    <p class="fs--2 mb-0 text-white p-4">Last Updated <x-friendly-date :date="$playlist->last_updated_on"/></p>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="d-flex"><span class="fa-stack ml-n1 mr-3"><svg style="    height: 1em;
                                                                                       width: 1em;" class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-200" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg>

                                    <svg class="svg-inline--fa fa-tag fa-w-16 fa-inverse fa-stack-1x text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tag" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">

                                        <g transform="translate(256 256)"><g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">

                                                <path fill="currentColor" d="M0 252.118V48C0 21.49 21.49 0 48 0h204.118a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.745 18.745-49.137 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118zM112 64c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z" transform="translate(-256 -256)"></path></g></g></svg>

                                </span>
                                <div class="flex-1">
                                    <h5 class="mb-2 fs-0">Contact</h5>
<span class="nav-link nav-link-card-details" href="#!"><svg class="svg-inline--fa fa-user fa-w-14 mr-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg><!-- <span class="fas fa-user mr-2"></span> -->
                                        {{ $playlist->owner }}
                                    </span>

                                    @foreach($playlist->contacts as $contact)
                                    @if(filter_var($contact, FILTER_VALIDATE_EMAIL))
                                    <div>
                                        <span class="nav-link nav-link-card-details" href="#!">
                                            <i class="fas fa-envelope mr-2"></i>
                                            <span class="mr-2">
                                                {{ $contact }}
                                            </span>
                                        </span>
                                    </div>
                                    @else
                                    <div>
                                        <span class="nav-link nav-link-card-details" href="#!">
                                            <i class="fab fa-instagram mr-2"></i>
                                            <span class="mr-2">
                                                <a href="{{"https://www.instagram.com/" . substr($contact, 1) . "/" }}" target="_blank">
                                                    {{"https://www.instagram.com/" . substr($contact, 1) . "/" }}
                                                </a>
                                            </span>
                                        </span>
                                    </div>
                                    @endif
                                    @endforeach
                                    <!--</span>-->

                                    <div id="bunsplaylistcard">
                                        <center>
                                            <a onclick="ym(73260880, 'reachGoal', 'generatemessage'); return true;" id="generatemsgbtn" style="width: 182px;    border-radius: 50px; " class="btn btn-primary btn-block my-4" href="{{ route('frontend.message-generator', $playlist) }}">Generate Message <i class="far fa-edit"></i></a>
                                            <a onclick="ym(73260880, 'reachGoal', 'playonspotify'); return true;" id="spotifybtn" style="width: 182px;    border-radius: 50px;    background: #1DB954; "   href="{{ $playlist->spotify_deep_link }}" class="btn btn-primary btn-block my-4">
                                                Play on spotify <i class="fab fa-spotify mr-1"></i>
                                            </a></center>
                                    </div>
                                    <hr class="my-4">
                                </div>
                            </div>
                            <div class="d-flex"><span class="fa-stack ml-n1 mr-3"><svg style="height: 1em;
                                                                                       width: 1em;" class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-200" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg><!-- <i class="fas fa-circle fa-stack-2x text-200"></i> --><svg  class="svg-inline--fa fa-align-left fa-w-14 fa-inverse fa-stack-1x text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="align-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.5em;"><g transform="translate(224 256)"><g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)"><path fill="currentColor" d="M12.83 352h262.34A12.82 12.82 0 0 0 288 339.17v-38.34A12.82 12.82 0 0 0 275.17 288H12.83A12.82 12.82 0 0 0 0 300.83v38.34A12.82 12.82 0 0 0 12.83 352zm0-256h262.34A12.82 12.82 0 0 0 288 83.17V44.83A12.82 12.82 0 0 0 275.17 32H12.83A12.82 12.82 0 0 0 0 44.83v38.34A12.82 12.82 0 0 0 12.83 96zM432 160H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 256H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z" transform="translate(-224 -256)"></path></g></g></svg><!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-align-left" data-fa-transform="shrink-2"></i> --></span>
                                <div class="flex-1">
                                    <h5 class="mb-2 fs-0">Playlist Analysis</h5>

                                    @foreach($playlist->moodiness as $mood => $value)
                                    <span>{{ ucfirst($mood) }}</span>
                                    <i class="fal fa-question-circle text-primary" title="{{$playlist->moodDescription($mood)}}" data-toggle="tooltip"></i>
                                    <div class="progress mb-3 position-lg-relative" style="height: 30px;"
                                         data-label="{{$playlist->moodValue($value)}} %">
                                        <div class="progress-bar bg-gradient-primary" role="progressbar"
                                             style="width: {{$playlist->moodValue($value)}}%; background-color: {{ $playlist->moodColor($mood) }}"
                                             aria-valuenow="{{$playlist->moodValue($value)}}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">

                            <ul class="nav flex-lg-column fs--1">
                                <li class="nav-item mr-2 mr-lg-0">

<span class="nav-link nav-link-card-details" href="#!"><i style="margin-right: 0.5rem !important;" class="fas fa-users"></i><!-- <span class="fas fa-user mr-2"></span> -->{{ $playlist->followers }} Followers</span>

                                </li>
                                <li class="nav-item mr-2 mr-lg-0">

<span class="nav-link nav-link-card-details" href="#!"><i style="margin-right: 0.5rem !important;" class="fas fa-list-ul"></i><!-- <span class="fas fa-tag mr-2"></span> -->{{ $playlist->number_of_tracks }} Tracks</span></li>

                                <li class="nav-item mr-2 mr-lg-0">

<span class="nav-link nav-link-card-details" href="#!"><i style="margin-right: 0.5rem !important;" class="fas fa-calendar"></i><!-- <span class="fas fa-tag mr-2"></span> -->Updated <x-friendly-date :date="$playlist->last_updated_on"/></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #generatemsgbtn
    {

        position: relative;
        animation-name: shake;
        animation-duration: 15s;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in;
        cursor: pointer;
    }
    #generatemsgbtn:hover {
        animation-name: shakeAnim;
    }
    @keyframes shakeAnim {
        0% {left: 0}
        1% {left: -3px}
        2% {left: 5px}
        3% {left: -8px}
        4% {left: 8px}
        5% {left: -5px}
        6% {left: 3px}
        7% {left: 0}
    }

    @keyframes shake {
        0% {left: 0}
        1% {left: -3px}
        2% {left: 5px}
        3% {left: -8px}
        4% {left: 8px}
        5% {left: -5px}
        6% {left: 3px}
        7% {left: 0}
    } 
</style>
