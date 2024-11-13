@props(["value" => date("Y-m-d", strtotime("now")),])
<input {{ $attributes->merge(['class' => 'input input-sm']) }} value="{{ $value }}" >
