@php

$flashName = \Flash::getName();

@endphp

@foreach (session($flashName, collect())->toArray() as $flash)
    <div @class([
        'alert',
        'alert-' . $flash['type'],
        'alert-dismissible'                     => $flash['dismissible'],
        !empty($flash['class'])                 => $flash['class'],
        (!empty($between) ? $between : 'mb-2')  => !$loop->last,
        (!empty($last) ? $last : '')            => $loop->last,
        'rounded-0'                             => !empty($flat),
    ]) role="alert">
        {!! $flash['icon'] !!}
        {!! $flash['message'] !!}
        @if($flash['dismissible'])
        <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-toggle="tooltip" title="Esconder" onclick="document.querySelector('.tooltip')?.remove()"></button>
        @endif
    </div>
@endforeach

<script>
window.onload = function() {
    if (window.jQuery) {
        $('div.alert:not(.alert-dismissible)').delay({{ !empty($timeout) ? (int) $timeout : 3500}}).fadeOut(350)
    }
};
</script>

{{ session()->forget($flashName) }}