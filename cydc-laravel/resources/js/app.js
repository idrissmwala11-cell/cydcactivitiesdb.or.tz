import './bootstrap';

// Import Bootstrap CSS and JS
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Import Alpine.js after Bootstrap to ensure proper CSS precedence
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Admin and User Search Handlers
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, initializing search functionality');
  
  // Simple test for admin search button
  const testBtn = document.getElementById('adminSearchBtn');
  if (testBtn) {
    console.log('Admin search button found:', testBtn);
    testBtn.addEventListener('click', function() {
      console.log('Admin search button clicked!');
    });
  } else {
    console.log('Admin search button NOT found');
  }

(function() {
  function getCsrf() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }

  function renderResults(container, results) {
    if (!Array.isArray(results) || results.length === 0) {
      container.innerHTML = '<div class="text-center text-muted py-3">No results found</div>';
      return;
    }
    const badgeClassByType = {
      'Parents Information': 'primary',
      'Center Leadership': 'info',
      'Special Program': 'success'
    };
    container.innerHTML = results.map(r => {
      const badge = badgeClassByType[r.type] || 'secondary';
      const url = r.url || (r.route && r.id ? (typeof route === 'function' ? route(r.route, r.id) : `/${r.route.replaceAll('.', '/')}/${r.id}`) : '#');
      return `
        <div class="d-flex align-items-start border-bottom py-3">
          <div class="me-3">
            <span class="badge bg-${badge}">${r.type || 'Item'}</span>
          </div>
          <div class="flex-fill">
            <div class="fw-semibold">${r.title || 'Untitled'}</div>
            <div class="small text-muted">By: ${r.user || ''} • ${r.date || ''} • Status: ${r.status || ''}</div>
          </div>
          <div class="ms-3">
            <a href="${url}" class="btn btn-sm btn-outline-primary">
              <i class="bi bi-box-arrow-up-right"></i>
            </a>
          </div>
        </div>`;
    }).join('');
  }

  function attachSearch({inputId, btnId, resultsRowId, resultsCountId, resultsContentId, ajaxUrl, method='POST'}) {
    const input = document.getElementById(inputId);
    const btn = document.getElementById(btnId);
    const row = document.getElementById(resultsRowId);
    const count = document.getElementById(resultsCountId);
    const content = document.getElementById(resultsContentId);
    if (!input || !btn || !row || !count || !content) return;

    async function doSearch() {
      const q = (input.value || '').trim();
      console.log('Search triggered with query:', q);
      if (!q) {
        row.style.display = 'none';
        content.innerHTML = '';
        count.textContent = '0';
        return;
      }
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Searching';
      console.log('Making request to:', ajaxUrl, 'with CSRF:', getCsrf());
      try {
        const res = await fetch(ajaxUrl, {
          method,
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrf()
          },
          body: JSON.stringify({ q })
        });
        console.log('Response status:', res.status);
        const data = await res.json();
        console.log('Response data:', data);
        if (data && data.success) {
          row.style.display = '';
          count.textContent = String(data.count || 0);
          renderResults(content, data.results || []);
        } else {
          row.style.display = '';
          count.textContent = '0';
          content.innerHTML = '<div class="text-danger">Search failed. Please try again.</div>';
        }
      } catch (e) {
        console.error('Search error:', e);
        row.style.display = '';
        count.textContent = '0';
        content.innerHTML = '<div class="text-danger">Network error. Please try again.</div>';
      } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-search me-1"></i>Search';
      }
    }

    btn.addEventListener('click', doSearch);
    input.addEventListener('keydown', (e) => { if (e.key === 'Enter') doSearch(); });
  }

  // Admin search wiring
  const adminBtn = document.getElementById('adminSearchBtn');
  const adminAjaxUrl = adminBtn ? (adminBtn.getAttribute('data-search-url') || '/search/ajax') : null;
  console.log('Admin search setup:', { adminBtn, adminAjaxUrl });
  if (adminBtn && adminAjaxUrl) {
    console.log('Attaching admin search functionality');
    attachSearch({
      inputId: 'adminSearchInput',
      btnId: 'adminSearchBtn',
      resultsRowId: 'searchResults',
      resultsCountId: 'resultsCount',
      resultsContentId: 'searchResultsContent',
      ajaxUrl: adminAjaxUrl,
      method: 'POST'
    });
  } else {
    console.log('Admin search not initialized - missing button or URL');
  }

  // User search wiring
  const userBtn = document.getElementById('userSearchBtn');
  const userAjaxUrl = userBtn ? (userBtn.getAttribute('data-search-url') || '/user/search/ajax') : null;
  if (userBtn && userAjaxUrl) {
    attachSearch({
      inputId: 'userSearchInput',
      btnId: 'userSearchBtn',
      resultsRowId: 'userSearchResults',
      resultsCountId: 'userResultsCount',
      resultsContentId: 'userSearchResultsContent',
      ajaxUrl: userAjaxUrl,
      method: 'POST'
    });
  }
})();

});
