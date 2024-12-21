@extends('layouts.app')

@section('title', 'Reported Reviews')

@section('content')

<script src="{{ asset('js/common/confirmation-modal.js') }}" defer></script>
@include('partials.common.confirmation-modal')

<div class="reported-reviews-container">
    <h1>Reported Reviews</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Reporter</th>
                <th>Report Reason</th>
                <th>Report Description</th>
                <th>Game</th>
                <th>Author</th>
                <th>Review Title</th>
                <th>Review Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportedReviews as $report)
                <tr>
                    <td>
                        <a href="{{ route('admin.users.profile', $report->buyer_id) }}">
                            {{ $report->buyer_username ?? 'N/A' }}
                        </a>
                    </td>
                    <td>{{ $report->reason_description ?? 'N/A' }}</td>
                    <td>{{ $report->report_description ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('game.details', ['id' => $report->game_id]) }}">
                            {{ $report->game_name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.profile', $report->author_id) }}">
                            {{ $report->author_username ?? 'N/A' }}
                        </a>
                    </td>
                    <td>{{ $report->review_title ?? 'N/A' }}</td>
                    <td>{{ $report->review_description ?? 'N/A' }}</td>
                    <td class="reported-reviews-actions">
                        <form action="{{ route('admin.reports.destroyReport', $report->report_id) }}" method="POST" style="display:inline;" id="delete-report-form-{{ $report->report_id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="confirmation-btn" id="btn-delete-report"
                                    data-title="Delete Report"
                                    data-message="Are you sure you want to delete this report?"
                                    data-form-id="delete-report-form-{{ $report->report_id }}">
                                Delete Report
                            </button>
                        </form>
                        <form action="{{ route('admin.reviews.destroyReview', $report->review_id ?? 0) }}" method="POST" style="display:inline;" id="delete-review-form-{{ $report->review_id ?? 0 }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="confirmation-btn" id="btn-delete-review"
                                    data-title="Delete Review"
                                    data-message="Are you sure you want to delete this review and all related data?"
                                    data-form-id="delete-review-form-{{ $report->review_id ?? 0 }}">
                                Delete Review
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $reportedReviews->links() }}
</div>
@endsection