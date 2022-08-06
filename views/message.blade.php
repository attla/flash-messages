@php

$flashName = \Flash::getName();

@endphp

@foreach (session($flashName, collect())->toArray() as $flash)
    <div @class([
        'alert',
        'alert-' . $flash['type'],
        'alert-dismissible'                     => $flash['dismissible'],
        $flash['class']                         => !empty($flash['class']),
        'alert-timeout'                         => !empty($flash['timeout']),
        (!empty($between) ? $between : 'mb-2')  => !$loop->last,
        (!empty($first) ? $first : '')          => $loop->first,
        (!empty($last) ? $last : '')            => $loop->last,
        'rounded-0'                             => !empty($flat),
    ]) role="alert"
    @if (!empty($flash['timeout']))
     data-alert-timeout="{{ $flash['timeout'] }}"
    @endif
    >
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
        $('div.alert.alert-timeout').each(function(){
            var me = $(this);
            me.delay(parseInt(me.data('alert-timeout')) * 1000).fadeOut(350)
        });
    }
};
</script>

{{ session()->forget($flashName) }}