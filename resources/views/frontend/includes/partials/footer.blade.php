<footer class="pt-5 pb-5">
    <section class="">
        <div class="container text-center text-md-start">
            <!-- Grid row -->
            <div class="mt-3 footer-links-wrapper mb-5 d-flex justify-content-center">
                <div class="mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="mb-2 text-white">
                        Playlistmap
                    </h6>
                    <ul>
                        <li class="mb-2">
                            <a href="/about">About</a>
                        </li>
                        <li class="mb-2">
                            <a href="#">Careers</a>
                        </li>
                        <li>
                            <a href="#">Refer and Earn</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="mb-2 text-white">
                        Get Started
                    </h6>
                    <ul>
                        <li class="mb-2">
                            <a href="/pricing">Pricing</a>
                        </li>
                        <li class="mb-2">
                            <a href="" data-toggle="modal" data-target="#register_modal" style="cursor:pointer">Sign Up</a>
                        </li>
                        <li class="mb-2">
                            <a href="/faq">FAQs</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="mb-2 text-white">
                        Press
                    </h6>
                    <ul>
                        <li class="mb-2">
                            <a href="#">Community</a>
                        </li>
                        <li class="mb-2">
                            <a href="#">Blog</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="mb-2 text-white">
                        Support
                    </h6>
                    <ul>
                        <li class="mb-2">
                            <a href="{{route('pages.privacy')}}">Privacy Policy</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('pages.terms')}}">Terms & Conditions</a>
                        </li>
                        <li class="mb-2">
                            <a href="/contact">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="mb-2 text-white">
                        Follow Us
                    </h6>

                    <ul>
                        <li class="mb-2">
                            <a target="_blank" href="https://facebook.com/playlistmap/"><i class="fab fa-facebook-square me-3"></i>Facebook</a>
                        </li>
                        <li class="mb-2">
                            <a target="_blank" href="https://instagram.com/playlistmap/"><i class="fab fa-instagram me-3"></i>Instagram</a>
                        </li>
                        <li class="mb-2">
                            <a target="_blank" href="https://tiktok.com/@playlistmap"><i class="fab fa-tiktok me-3"></i>Tiktok</a>
                        </li>
                        <li class="mb-2">
                            <a target="_blank" href="https://linkedin.com/company/playlistmap-com"><i class="fab fa-linkedin me-3"></i>Linkedin</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>

    </section>
    <!-- Section: Links  -->


    <div class="row g-0 justify-content-between fs--1 mt-4">
        <div class="col-12 text-center rights d-flex align-items-center justify-content-center">
            <img class="me-4" src="{{ asset('images/logo-w.webp') }}" alt="" width="100" />
            <div>&copy; {{ now()->format('Y') }} Playlistmap, Inc. • All rights reserved.</div>
        </div>
    </div>
</footer>

<style>
    .footer-links-wrapper a:hover{
        padding:5px;
        background-color: #1b1b1b;
        border-radius: 50rem;
        transition: 0.5s;
    }
</style>