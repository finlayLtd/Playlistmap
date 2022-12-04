<section class="{{$page ?? ""}}-section {{$page ?? ""}}-section-testimonials playlistmap-testimonials">
    <div class="wrap">
        <h2 class="text-center position-relative container">
            <span class="position-relative">
                {{$title ?? "Your Success Speaks Volumes"}}
                @if(!isset($showTitleQuote))
                <img class="big-red-quote" src="{{asset('/images/graphics/red-quotes-big.svg')}}" />
                @endif
            </span>
        </h2>
        <div class="testimonials-arrows justify-content-end mb-4 mt-4">
            <div class="testimonials-button testimonials-prev d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-chevron-left"></i></div>
            <div class="testimonials-button testimonials-next d-flex justify-content-center align-items-center active"><i class="fa-solid fa-chevron-right"></i></div>
        </div>
        <div class="testimonials-wrapper container">
            <div class="single-testimonial container">
                <div class="d-flex">
                    <div class="image-wrapper position-relative me-3">
                        <img class="graphic graphic-left" src="{{asset('/images/testimonials/alusin.webp')}}" />
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="testimonial-title mb-0">Alusin</h6>
                        <div class="testimonial-job-title secondary-color">Music Producer</div>
                    </div>
                </div>
                <div class="testimonial-content secondary-color">
                    “ With PlaylistMap, one of the biggest problems we face as creators releasing music has been solved. Now I can use the site’s ready-made templates to easily reach any playlist I want instead of having to deal with the endless rewriting of emails. I definitely recommend this platform. ”
                </div>
                <div class="mt-3">
                    <img class="graphic graphic-left" src="{{asset('/images/graphics/red-quotes.svg')}}" />
                </div>
            </div>
            <div class="single-testimonial container">
                <div class="d-flex">
                    <div class="image-wrapper position-relative me-3">
                        <img class="graphic graphic-left" src="{{asset('/images/testimonials/eliav.webp')}}" />
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="testimonial-title mb-0">X-Hood21</h6>
                        <div class="testimonial-job-title secondary-color">Music Producer</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    “ My experience with PlaylistMap has change everything I thought I knew about playlisting. Thanks to PlaylistMap, I was able to save tons of time and money, create strong and fruitful connections with curators, and gain the ability to reach out to many more in the click of a button! ”
                </div>
                <div class="mt-3">
                    <img class="graphic graphic-left" src="{{asset('/images/graphics/red-quotes.svg')}}" />
                </div>
            </div>
            <div class="single-testimonial container">
                <div class="d-flex">
                    <div class="image-wrapper position-relative me-3">
                        <img class="graphic graphic-left" src="{{asset('/images/testimonials/ronny.webp')}}" />
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="testimonial-title mb-0">Ronny</h6>
                        <div class="testimonial-job-title secondary-color">Hip Hop Artists</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    “ This tool is f**king amazing! Saved so much time and effort for me to search and find good playlists for my genre and most importantly, it gives you the contact info for every playlist curator. I mean, this is crazy man, I could search for hours for a good playlist and sometimes it took even longer to find their contact info, but now it's all in front of you! ”
                </div>
                <div class="mt-3">
                    <img class="graphic graphic-left" src="{{asset('/images/graphics/red-quotes.svg')}}" />
                </div>
            </div>
            <div class="single-testimonial">
                <div class="d-flex">
                    <div class="image-wrapper position-relative me-3">
                        <img class="graphic graphic-left" src="{{asset('/images/testimonials/yarden.webp')}}" />
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="testimonial-title mb-0">Yarden Saxophone</h6>
                        <div class="testimonial-job-title secondary-color">Artist</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    “ Playlistmap is a game changer for both signed and independent musicians. It's a must-have tool for every artist who wants to get their music to as many listeners as possible. It saved me so much valuable time, and put me in touch with so many playlist curators. For me it's an essential part of every new release campaign. ”
                </div>
                <div class="mt-3">
                    <img class="graphic graphic-left" src="{{asset('/images/graphics/red-quotes.svg')}}" />
                </div>
            </div>
        </div>
    </div>
</section>

@section('footer-scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection