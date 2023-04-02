@extends('hanoivip::layouts.app')

@section('title', 'Topup with Pagar')

@section('content')

@if (!empty($guide))
	<p>{{$guide}}</p>
@endif

@php
$customer = $data['customer'];
$billing = $data['billing'];
$shipping = $data['shipping'];
$param = $data['param'];
@endphp


<form method="post" action="{{route('newtopup.do')}}">
	{{ csrf_field() }}
	<input type="hidden" name="trans" id="trans" value="{{$trans}}" />
	<input type="hidden" name="channel" id="channel" value="credit_card" />
	
	<h1>Customer info</h1>
	Name: <input type="text" id="customer_name" name="customer_name" value="{{ isset($customer['name']) ? $customer['name'] : '' }}" />
	Document: <select id="customer_doc_type" name="customer_doc_type"><option value="cpf">cpf</option></select>
	<input type="text" id="customer_doc_number" name="customer_doc_number" value="{{ isset($customer['documents']['number']) ? $customer['documents']['number'] : '' }}" />
	Phone: <input type="text" id="customer_phone" name="customer_phone" value="{{ isset($customer['phone_numbers'][0]) ? $customer['phone_numbers'][0] : '' }}" />
	Email: <input type="text" id="customer_email" name="customer_email" value="{{ isset($customer['email']) ? $customer['email'] : '' }}" />
	<h1>Billing info</h1>
	Name: <input type="text" id="billing_name" name="billing_name" value="{{ isset($billing['name']) ? $billing['name'] : '' }}" />
	Street: <input type="text" id="billing_street" name="billing_street" value="{{ isset($billing['address']['street']) ? $billing['address']['street'] : '' }}" />
	Street Number: <input type="text" id="billing_street_number" name="billing_street_number" value="{{ isset($billing['address']['street_number']) ? $billing['address']['street_number'] : '' }}" />
	State: <input type="text" id="billing_name" name="billing_state" value="{{ isset($billing['address']['state']) ? $billing['address']['state'] : '' }}" />
	City: <input type="text" id="billing_name" name="billing_city" value="{{ isset($billing['address']['city']) ? $billing['address']['city'] : '' }}" />
	Neighborhood: <input type="text" id="billing_name" name="billing_neighborhood" value="{{ isset($billing['address']['neighborhood']) ? $billing['address']['neighborhood'] : '' }}" />
	Zipcode: <input type="text" id="billing_name" name="billing_zipcode" value="{{ isset($billing['address']['zipcode']) ? $billing['address']['zipcode'] : '' }}" />
	<h1>Credit info</h1>
	Card Number: <input type="text" id="credit_number" name="credit_number" value="{{ isset($credit['card_number']) ? isset($credit['card_number']) : '' }}" />
	Card Expire: <input type="text" id="credit_expire" name="credit_expire" value="{{ isset($credit['card_expiration_date']) ? isset($credit['card_expiration_date']) : '' }}" />
	Card Holder: <input type="text" id="credit_holder" name="credit_holder" value="{{ isset($credit['card_holder_name']) ? isset($credit['card_holder_name']) : '' }}" />
	Card CCV: <input type="text" id="credit_ccv" name="credit_ccv" value="{{ isset($credit['card_cvv']) ? isset($credit['card_cvv']) : '' }}" />
	
	<button type="submit">OK</button>
</form>


@endsection
