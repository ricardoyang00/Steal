
@if($sales->isNotEmpty())
    <div class="sales-report-template">
        <h3>Total Sales: € {{ $total }}</h3>
    </div>
    <table class="table-sales-report">
        <thead>
            <tr>
                <th>Game</th>
                <th>Value</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->getcdk->getgame->name }}</td>
                <td>€ {{ number_format($sale->getpurchase->value, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($sale->getpurchase->getorder->time)->format('d/m/Y H:i:s') }}</td>
                <td>
                    <a href="{{ route('admin.purchases.details', ['id' => $sale->getpurchase->id]) }}" class="btn btn-info btn-sm">Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif