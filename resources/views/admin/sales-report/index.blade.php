@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="container mt-5">
    <h1>Sales Report</h1>
    <ul>
        <li><a href="{{ route('admin.salesReport.daily') }}">Daily Sales Report</a></li>
        <li><a href="{{ route('admin.salesReport.weekly') }}">Weekly Sales Report</a></li>
        <li><a href="{{ route('admin.salesReport.monthly') }}">Monthly Sales Report</a></li>
        <li><a href="{{ route('admin.salesReport.custom') }}">Custom Sales Report</a></li>
    </ul>
</div>
@endsection