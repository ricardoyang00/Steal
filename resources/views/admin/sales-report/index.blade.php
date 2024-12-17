@extends('layouts.app')

<script src="{{ asset('js/admin/sales-report.js') }}" defer></script>

@section('title', 'Sales Report')

@section('content')
<div class="admin-sales-report-page">
    <h1>Sales Report</h1>
    <div class="button-group">
        <button type="button" onclick="loadContent('daily')">Daily</button>
        <button type="button" onclick="loadContent('weekly')">Weekly</button>
        <button type="button" onclick="loadContent('monthly')">Monthly</button>

        <!-- Custom Sales Report with date range -->
        <form id="custom-sales-form" onsubmit="loadCustomContent(event)">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <button type="submit">Custom</button>
        </form>
    </div>

    <!-- Content will be dynamically loaded here -->
    <div id="sales-report-content">
        @include('partials.admin.sales-report.daily') <!-- Load 'daily' by default -->
    </div>
</div>
@endsection
