@component('mail::message')
# Dragă Fr:. {{ $rsvp->user()->name }}

{{ $rsvp->meeting()->text }}

@component('mail::button', ['url' => $rsvp->secret])
Răspunde
@endcomponent

Te îmbrățișez,

Fr:. S:.
{{ $rsvp->meeting()->date }}

@endcomponent