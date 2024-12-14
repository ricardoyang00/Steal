@extends('layouts.app')

@section('title', 'Purchase History for ' . $game->name)

@section('content')
<div class="seller-purchase-history-page">
    <h1>
        <a href=" {{ url('seller/products') }} ">
            <i class="fa-solid fa-chevron-left" style="color: white;"></i>
        </a>Purchase History of {{ $game->name }}
    </h1>

    @if ($purchases->isEmpty())
        <div class="alert alert-info" style="color: white;">
            No purchases found for this game.
        </div>
    @else
        <table class="table table-bordered" style="color: white;">
            <thead>
                <tr>
                    <th>CDK</th>
                    <th>Buyer</th>
                    <th>Value</th>
                    <th>Purchase Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->cdk_code }}</td>
                        <td>{{ $purchase->buyer_name }}</td>
                        <td>€{{ number_format($purchase->value, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($purchase->time)->format('d/m/Y H:i:s') }}</td>
                        <td><a href="{{ route('seller.purchases.details', ['id' => $purchase->id]) }}" class="btn btn-info">Details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-links">
            {{ $purchases->links() }}
        </div>
    @endif
</div>
@endsection