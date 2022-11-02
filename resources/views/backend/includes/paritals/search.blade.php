<form action="{{ $route }}">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search" value="{{ request('q') }}">
        <div class="input-group-append">
            <button type="submit" class="input-group-text">
                <i class="fa fa-search"></i>
            </button>
            <a href="{{ $route }}" class="input-group-text">
                <i class="fa fa-refresh"></i>
            </a>
        </div>
    </div>
</form>
