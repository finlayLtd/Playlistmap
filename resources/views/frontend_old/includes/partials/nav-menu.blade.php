
<div class="collapse navbar-collapse scrollbar" id="navbarStandard">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a onclick="ym(73260880, 'reachGoal', 'navsearch'); return true;" style="display:flex" class="nav-link" href="{{ route('frontend.search') }}"><i id="searchicon" class="fas fa-search"></i> Search</a>
        </li>
        @guest
        <li class="nav-item">
            <a class="nav-link" href="/pricing">Pricing</a>
        </li>
        <li class="nav-item" style="margin-right: 5%;">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        <li id="btntopregister" class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Start For Free</a>
        </li>
        @endguest
    </ul>

</div>
<ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center justify-content-end w-100">


    @auth
    <li class="nav-item mr-3">
        <a onclick="ym(73260880, 'reachGoal', 'unlcoks'); return true;" style="display:flex" class="nav-link" href="{{ route('frontend.profile') }}#myunlocks"><i id="searchicon" class="fas fa-unlock"></i> Unlocks</a>
    </li>
    <li class="nav-item mr-3">
        <a onclick="ym(73260880, 'reachGoal', 'creditsnav'); return true;" href="/manage-plans">
            <span id="creditsleft" class="badge badge-soft-success lh-lg">{{ user()->subscription()->getFeatureRemainings('credits') }} Credits Left</span></a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link pr-0 d-flex " id="navbarDropdownUser" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="mr-3 align-self-center">{{ user()->name }}</div>
            <div class="avatar avatar-xl">
                
               <img alt="" class="rounded-circle" src="{{ user()->avatar_url }}"  />
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser">
            <div class="bg-white rounded-lg py-2">
                @role('admin')
                <a class="dropdown-item" href="{{ route('backend.dashboard') }}">Dashboard</a>
                @endrole
                <a onclick="ym(73260880, 'reachGoal', 'profileinusermenu'); return true;" class="dropdown-item" href="{{ route('frontend.profile') }}">Profile</a>
                <a onclick="ym(73260880, 'reachGoal', 'navbarupgrade'); return true;" class="dropdown-item" href="/manage-plans">Plans</a>

                <div class="dropdown-divider"></div>
                <a  class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();ym(73260880, 'reachGoal', 'navlogout'); return true;">Logout</a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
    @endauth
</ul>

<style>
    #btntopregister
    {
        border: 1px solid white;
        border-radius: 12px;
        padding-right: 2%;
        padding-left: 2%;
        height: 26px;
        line-height: 0.5;
        font-weight: 400;
        letter-spacing: 1px;
        width: 160px;
        text-align: center;
        margin-top: 2%;
        background: white;
    }
    #btntopregister > a
    {
        color: #333;
        font-weight: 600;
    }
    #btntopregister:hover a
    {color:#3d3d3d;}

    #searchicon
    {
        font-size: 15px;margin-right:4px;margin-top:2%;
    }

    @media only screen and (max-width: 600px) {
        #searchicon
        {
            font-size: 15px;margin-right:5px;margin-top:0%;
        }
        .nav-link
        {font-size: 14px;
         font-weight: 400;}
        #btntopregister
        {border:1px solid black}
    }

</style>


<!-- Black Friday -->


<div id="black-friday-2021-nav">
    <div class="blackfridaybox">
        <div>Take 50% off all plans. Applied at plan page. Hurry, Offer Ends Soon! : <div id="demo"></div></div>
        
    
        <a href="@auth /manage-plans @endauth @guest /pricing @endguest" class="btnblackfriday">Get The Deal</a>
    </div>
    <div id="close-bf21-popup" class="closePopup">
        <i class="fas fa-times"></i> 
    </div>
</div>

<script>
    (function () {
// Set the date we're counting down to
        var countDownDate = new Date("Nov 26, 2021 23:59:59").getTime();

// Update the count down every 1 second
        var x = setInterval(function () {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);
        
//        $('.closePopup').on('click', (e) => {
//            $('#black-friday-2021-nav').hide();
//        });
        
        document.getElementById("close-bf21-popup").addEventListener("click", function() {
            document.getElementById("black-friday-2021-nav").style.display = "none";
            document.getElementsByTagName('body')[0].style.marginTop = "0";
             document.getElementsByTagName('body')[0].classList.add("bf-pu-hidden");
          });
    })();

</script>

<style>
    .btnblackfriday
    {
        background-color: #2332a4;
        width: 160px;
        height: auto;
        border: none;
        color: white;
        padding: 8px 6px;
        text-align: center;
        text-decoration: none;
        font-family: 'Roboto', sans-serif;
        margin-left: 20px;
    }

    .btnblackfriday:hover{
        color: #fff;
        text-decoration: none;
        opacity: 0.8;
    }
    .blackfridaybox {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
    }

    .blackfridaybox p{
        margin-bottom: 0;
    }

    #black-friday-2021-nav{
        background-color: rgb(63,81,181);
        color: rgba(255,255,255,0.87);
        height: 64px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 9999999;
    }

    .closePopup{
        position: absolute;
        top: 0;
        bottom: 0;
        right: 20px;
        margin: auto;
        height: 32px;
        font-size: 23px;
        cursor: pointer;
    }
    
    .closePopup svg{
        pointer-events: none;
    }
    
    body{
        margin-top: 64px;
    }
    
    body.home nav.navbar{
        top: 64px;
    }
    
    body.home #searchform.homepage-form-search.in-header{
        top: 69px;
    }
    
    body.home.bf-pu-hidden nav.navbar{
        top: 0;
    }
    
    body.home.bf-pu-hidden #searchform.homepage-form-search.in-header{
        top: 5px;
    }
    
    #black-friday-2021-nav .blackfridaybox #demo{
        display: inline-block;
    }
    
    #paymentModal .payment-wrapper{
        display: none;
    }
    
    @media only screen and (max-width: 800px) {
        #black-friday-2021-nav{
            height: 110px;
            padding: 0 20px;
        }
        
        #black-friday-2021-nav .blackfridaybox{
            flex-direction: column;
        }
        
        #black-friday-2021-nav .blackfridaybox .btnblackfriday{
            margin-top: 10px;
        }
        
        #black-friday-2021-nav .blackfridaybox #demo{
            display: inline-block;
        }
        
        #black-friday-2021-nav .closePopup{
            top: 5px;
            bottom: unset;
            right: 5px;
        }
        
         body{
            margin-top: 110px;
        }

        body.home nav.navbar{
            top: 110px;
        }

        body.home #searchform.homepage-form-search.in-header{
            top: 115px;
        }
     }
    
    
</style>

