<div class="sales-report">
    <h2>Sales Report from {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} 
        to {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</h2>
    
    @include ('partials.admin.sales-report.template')

    @if($sales->isEmpty())
        <p class="text-center">No sales found for this period.</p>
    @endif
</div>
