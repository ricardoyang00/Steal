<div class="container mt-5">
    <h2>Montly Sales Report</h2>
    @include ('partials.admin.sales-report.template')

    @if($sales->isEmpty())
        <p class="text-center">No sales found for this month.</p>
    @endif
</div>
