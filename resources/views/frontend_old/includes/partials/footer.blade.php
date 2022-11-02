<footer>
    <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 text-600 opacity-85">
                {{ now()->format('Y') }} &copy; <a class="opacity-85" href="{{ route('home') }}">{{ config('app.name') }}</a>
            </p>
        </div>
        <div class="col-12 col-sm-auto text-center">
        </div>
    </div>
</footer>
