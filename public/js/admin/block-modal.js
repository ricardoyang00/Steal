function showBlockModal(gameId) {
    document.getElementById('game_id').value = gameId;
    document.getElementById('blockModal').style.display = 'block';
}

function closeBlockModal() {
    document.getElementById('blockModal').style.display = 'none';
}