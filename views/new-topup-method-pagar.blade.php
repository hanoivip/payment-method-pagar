@extends('hanoivip::layouts.app')

@section('title', 'Topup with Pagar')

@section('content')

@if (!empty($guide))
	<p>{{$guide}}</p>
@endif


<form method="post" action="{{route('newtopup.do')}}">
	{{ csrf_field() }}
	<input type="hidden" name="trans" id="trans" value="{{$trans}}" />
	<input type="hidden" name="channel" id="channel" value="credit_card" />
	
	<h1>Customer info</h1>
	Name: <input type="text" id="customer.name" name="customer.name" value="{{ isset($customer['name']) ? $customer['name'] : '' }}" />
	Document: <select id="customer.doc_type" name="customer.doc_type"><option value="cpf">cpf</option></select>
	<input type="text" id="customer.doc_number" name="customer.doc_number" value="{{ isset($customer['documents']['number']) ? $customer['documents']['number'] : '' }}" />
	Phone: <input type="text" id="customer.phone" name="customer.phone" value="{{ isset($customer['phone_numbers'][0]) ? $customer['phone_numbers'][0] : '' }}" />
	Email: <input type="text" id="customer.email" name="customer.email" value="{{ isset($customer['email']) ? $customer['email'] : '' }}" />
	<h1>Billing info</h1>
	Name: <input type="text" id="billing.name" name="billing.name" value="{{ isset($billing['name']) ? $billing['name'] : '' }}" />
	Street: <input type="text" id="billing.street" name="billing.street" value="{{ isset($billing['address']['street']) ? $billing['address']['street'] : '' }}" />
	Street Number: <input type="text" id="billing.street_number" name="billing.street_number" value="{{ isset($billing['address']['street_number']) ? $billing['address']['street_number'] : '' }}" />
	State: <input type="text" id="billing.name" name="billing.state" value="{{ isset($billing['address']['state']) ? $billing['address']['state'] : '' }}" />
	City: <input type="text" id="billing.name" name="billing.city" value="{{ isset($billing['address']['city']) ? $billing['address']['city'] : '' }}" />
	Neighborhood: <input type="text" id="billing.name" name="billing.neighborhood" value="{{ isset($billing['address']['neighborhood']) ? $billing['address']['neighborhood'] : '' }}" />
	Zipcode: <input type="text" id="billing.name" name="billing.zipcode" value="{{ isset($billing['address']['zipcode']) ? $billing['address']['zipcode'] : '' }}" />
	<h1>Credit info</h1>
	Card Number: <input type="text" id="credit.number" name="credit.number" value="{{ isset($credit['card_number']) ? isset($credit['card_number'] : '' }}" />
	Card Expire: <input type="text" id="credit.expire" name="credit.expire" value="{{ isset($credit['card_expiration_date']) ? isset($credit['card_expiration_date'] : '' }}" />
	Card Holder: <input type="text" id="credit.holder" name="credit.holder" value="{{ isset($credit['card_holder_name']) ? isset($credit['card_holder_name'] : '' }}" />
	Card CCV: <input type="text" id="credit.ccv" name="credit.ccv" value="{{ isset($credit['card_cvv']) ? isset($credit['card_cvv'] : '' }}" />
	
	<button type="submit">OK</button>
</form>


@endsection
