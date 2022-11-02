@props([
    'date',
    'format' => 'F d, Y'
])

@if($date)
<span title="{{ $date->format($format) }}" style="cursor: pointer">{{ $date->diffForHumans() }}</span>
@endif
