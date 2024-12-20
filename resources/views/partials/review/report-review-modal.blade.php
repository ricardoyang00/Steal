<div id="report-review-modal" class="modal">
    <div class="modal-content">
        <span class="close report-review-close-button">&times;</span>
        <div class="modal-header">
            <h2>Report Review</h2>
        </div>
        <div class="modal-body report-review-body">
            <form id="report-review-form" action="/reviews/report" method="POST">
                @csrf
                <input id="review-id-input" type="hidden" name="review_id" value="{{ $review->id }}">
                <div class="form-group">
                    <label for="report-reason">Reason</label>
                    <select id="report-reason" name="reason_id" class="form-control" required>
                        @foreach ($reportReasons as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->description }}</option>
                        @endforeach
                        <option value="">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="report-description">Description</label>
                    <textarea id="report-description" name="description" class="form-control" rows="3" maxlength="500" placeholder="You do not have to provide a description, but it is required if 'Other' is selected."></textarea>
                </div>
                <button type="submit" class="btn-report-submit">Submit</button>
            </form>
        </div>
    </div>
</div>