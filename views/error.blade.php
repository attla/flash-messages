@if ($errors->any())
<div @class([
    'alert alert-danger alert-dismissible',
    (!empty($last) ? $last : '')            => !empty($last) ? $last : '',
    'rounded-0'                             => !empty($flat),
]) role="alert">
    @foreach($errors->all() as $error)
    {{ $error }}<br/>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-toggle="tooltip" title="Esconder" onclick="document.querySelector('.tooltip')?.remove()"></button>
</div>
@endif
