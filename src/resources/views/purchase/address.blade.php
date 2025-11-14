@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/address.css') }}">
@endsection

@section('content')
<main class="contents">
    <h1 class="contents-ttl">
        住所の変更
    </h1>
    <form class="contents-update" action="{{ route('purchase.address.update', ['item_id' => $product->id]) }}" method="POST">
        @csrf
        <div class="postcode">
            <h2 class="postcode-ttl">郵便番号</h2>
            @error('postal_code')
                <p class="error">{{ $message }}</p>
            @enderror
            <input type="text" class="postcode-txt" name="postal_code" value="{{ old('postal_code', $address['postal_code'] ?? '') }}">
        </div>
        <div class="address">
            <h2 class="address-ttl">住所</h2>
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
            <input type="text" class="address-txt" name="address" value="{{ old('address', $address['address'] ?? '') }}">
        </div>
        <div class="building">
            <h2 class="building-ttl">建物名</h2>
            <input type="text" class="building-txt" name="building" value="{{ old('building', $address['building'] ?? '') }}">
        </div>
        <button type="submit" class="contents-update-btn">更新する</button>
    </form>
</main>
@endsection