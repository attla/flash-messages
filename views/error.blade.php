@if ($errors->any())
<div @class([
    'alert alert-danger alert-dismissible',
    'rounded-0'                             => !empty($flat),
    (!empty($first) ? $first : '')          => $loop->first,
    (!empty($last) ? $last : '')            => $loop->last,
]) role="alert">
    @foreach($errors->all() as $error)
    {{ $error }}<br/>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-toggle="tooltip" title="Esconder" onclick="document.querySelector('.tooltip')?.remove()"></button>
</div>
@endif
