<div id="blockModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeBlockModal()">&times;</span>
        <h2>Block Game</h2>
        <form id="blockForm" action="{{ route('admin.games.block', $game->id) }}" method="POST">
            @csrf
            <input type="hidden" name="game_id" id="game_id">
            <label for="reason">Reason for Blocking:</label>
            <textarea name="reason" id="reason" rows="4" maxlength="200" required></textarea>
            <div class="modal-buttons">
                <button type="button" class="cancel-btn" onclick="closeBlockModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Confirm</button>
            </div>
        </form>
    </div>
</div>