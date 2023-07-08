@foreach($connectionInCommon as $cc)
<div class="p-2 shadow rounded mt-2  text-white bg-dark">{{$cc->name}} - {{$cc->email}}</div>
@endforeach