@props(['playlist', 'col', 'tags'])

@php($count = count(array_slice($tags, 5)))

@if($count)
    <span class="badge text-primary d-block cursor-pointer text-left pl-0" data-toggle="modal"
          data-target="#pld_{{ $playlist->id }}_{{$col}}_modal">
        and {{$count}} more
    </span>

    <div class="modal fade" id="pld_{{ $playlist->id }}_{{$col}}_modal" tabindex="-1" aria-labelledby="pld_{{ $playlist->id }}_{{$col}}_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-4">
                    @foreach(array_slice($tags, 5) as $tag)
                        <a class="hover-text-decoration-none"
                           href="{{ route('frontend.search', ['q' => $tag]) }}">
                            <span class="badge badge-soft-info cursor-pointer">{{ $tag }}</span>
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endif
