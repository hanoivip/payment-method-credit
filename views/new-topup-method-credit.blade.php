@extends('hanoivip::layouts.app')

@section('title', 'Pay with web credit')

@section('content')

@if (!empty($guide))
	<p>{{$guide}}</p>
@endif

@if (!empty($data))
<form method="post" action="{{route('newtopup.do')}}">
{{ csrf_field() }}
<input type="hidden" id="trans" name="trans" value="{{$trans}}"/>
	@foreach ($data as $info)
		<p>Balance type: {{$info->type}}, balance: {{$info->balance}}</p>
	@endforeach
	<button type="submit">{{__('hanoivip.payment::payment.methods.next')}}</button>
</form>
@else
	<p>{{__('hanoivip.payment::payment.credit.no-point')}}</p>
@endif

@endsection
