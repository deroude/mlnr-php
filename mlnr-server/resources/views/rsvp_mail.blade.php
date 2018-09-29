@component('mail::message')
# Dragă Fr:. {{ $name }}

{{ $text }}

@component('mail::button', ['url' => $secret])
Răspunde
@endcomponent

Te îmbrățișez,

Fr:. S:.
{{ $date }}

@endcomponent