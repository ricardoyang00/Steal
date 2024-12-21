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
                <th>Reviewer</th>
                <th>Reason</th>
                <th>Review</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportedReviews as $report)
                <tr>
                    <td>{{ $report->buyer_name ?? 'N/A' }}</td>
                    <td>{{ $report->reason_description ?? 'N/A' }}</td>
                    <td>{{ $report->review_title ?? 'N/A' }}</td>
                    <td>{{ $report->report_description ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('admin.reviews.destroy', $report->review_id ?? 0) }}" method="POST" style="display:inline;" id="delete-review-form-{{ $report->review_id ?? 0 }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="confirmation-btn" id="btn-delete"
                                    data-title="Delete Review"
                                    data-message="Are you sure you want to delete this review and all related data?"
                                    data-form-id="delete-review-form-{{ $report->review_id ?? 0 }}">
                                Delete
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