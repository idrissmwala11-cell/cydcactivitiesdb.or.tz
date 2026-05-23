// Simple search test to bypass existing complex code
console.log('Search test script loaded');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM ready - testing search functionality');
    
    // Find the admin search button
    const searchBtn = document.getElementById('adminSearchBtn');
    const searchInput = document.getElementById('adminSearchInput');
    const resultsDiv = document.getElementById('searchResults');
    const resultsContent = document.getElementById('searchResultsContent');
    const resultsCount = document.getElementById('resultsCount');
    
    console.log('Elements found:', {
        searchBtn: !!searchBtn,
        searchInput: !!searchInput,
        resultsDiv: !!resultsDiv,
        resultsContent: !!resultsContent,
        resultsCount: !!resultsCount
    });
    
    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Search button clicked!');
            
            const query = searchInput.value.trim();
            console.log('Search query:', query);
            
            if (!query) {
                console.log('Empty query, skipping search');
                return;
            }
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('CSRF token:', csrfToken);
            
            // Show loading state
            searchBtn.disabled = true;
            searchBtn.innerHTML = 'Searching...';
            
            // Make the request
            const url = '/admin/search/ajax';
            console.log('Making request to:', url);
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ q: query })
            })
            .then(response => {
                console.log('Response received:', response.status, response.statusText);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                // Show results
                if (resultsDiv) {
                    resultsDiv.style.display = 'block';
                }
                
                if (resultsCount) {
                    resultsCount.textContent = data.count || 0;
                }
                
                if (resultsContent) {
                    if (data.success && data.results && data.results.length > 0) {
                        resultsContent.innerHTML = data.results.map(result => `
                            <div class="border-bottom py-2">
                                <strong>${result.type}</strong>: ${result.title}<br>
                                <small>User: ${result.user} | Date: ${result.date}</small>
                            </div>
                        `).join('');
                    } else {
                        resultsContent.innerHTML = '<div class="text-muted">No results found</div>';
                    }
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                if (resultsContent) {
                    resultsContent.innerHTML = '<div class="text-danger">Error: ' + error.message + '</div>';
                }
                if (resultsDiv) {
                    resultsDiv.style.display = 'block';
                }
            })
            .finally(() => {
                // Reset button
                searchBtn.disabled = false;
                searchBtn.innerHTML = '<i class="bi bi-search me-1"></i>Search';
            });
        });
        
        // Also handle Enter key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchBtn.click();
            }
        });
        
        console.log('Search functionality attached successfully');
    } else {
        console.error('Required search elements not found!');
    }
});