@extends('layouts.app')

<script src="{{ asset('js/admin/sales-report.js') }}" defer></script>

@section('title', 'Sales Report')

@section('content')
<div class="container mt-5">
    <h1>Sales Report</h1>
    <div class="mb-3">
        <button type="button" class="btn btn-link" onclick="loadContent('daily')">Daily</button>
        <button type="button" class="btn btn-link" onclick="loadContent('weekly')">Weekly</button>
        <button type="button" class="btn btn-link" onclick="loadContent('monthly')">Monthly</button>

        <!-- Custom Sales Report with date range -->
        <form id="custom-sales-form" onsubmit="loadCustomContent(event)">
            <div class="form-group d-inline-block me-2">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group d-inline-block me-2">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-link">Custom</button>
        </form>
    </div>

    <!-- Content will be dynamically loaded here -->
    <div id="sales-report-content">
        @include('partials.admin.sales-report.daily') <!-- Load 'daily' by default -->
    </div>
</div>
@endsection