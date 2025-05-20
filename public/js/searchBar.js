document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) 
    {
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const query = searchInput.value.trim();
                if (query.length > 0) {
                    window.location.href = `/produit/search?query=${encodeURIComponent(query)}`;
                }
            }
        });
    }
});