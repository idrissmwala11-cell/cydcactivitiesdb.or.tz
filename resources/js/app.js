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

document.addEventListener('DOMContentLoaded', function () {
  const drawer = document.getElementById('chatDrawer');
  const contactsEl = document.getElementById('chatContacts');
  const selectedContactEl = document.getElementById('chatSelectedContact');
  const messagesEl = document.getElementById('chatMessagesContainer');
  const formEl = document.getElementById('chatMessageForm');
  const recipientIdEl = document.getElementById('chatRecipientId');
  const messageInputEl = document.getElementById('chatMessageInput');
  const chatToggle = document.getElementById('chatDrawerToggle');

  if (!drawer || !contactsEl || !selectedContactEl || !messagesEl || !formEl || !recipientIdEl || !messageInputEl) {
    return;
  }

  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  const dataUrl = '/chat/data';
  const sendUrl = '/chat';
  let selectedUserId = null;
  let pollTimer = null;
  let lastUnreadCount = 0;
  let lastMessageId = 0;
  let isDrawerOpen = false;

  function escapeHtml(value) {
    return String(value ?? '')
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }

  function chatAvatar(person, size = 34) {
    const initials = escapeHtml(person.initials || person.sender_initials || 'U');
    const avatarUrl = person.avatar_url || person.sender_avatar_url;
    const image = avatarUrl
      ? `<img src="${escapeHtml(avatarUrl)}" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover" onerror="this.style.display='none'">`
      : '';

    return `<span class="d-inline-flex align-items-center justify-content-center rounded-circle overflow-hidden flex-shrink-0" style="width:${size}px;height:${size}px;position:relative;background:linear-gradient(135deg,#0f766e,#2563eb);color:#fff;font-weight:700;font-size:${Math.max(10, Math.round(size * .34))}px"><span>${initials}</span>${image}</span>`;
  }

  function playBeep() {
    try {
      const audioContext = new (window.AudioContext || window.webkitAudioContext)();
      const oscillator = audioContext.createOscillator();
      const gainNode = audioContext.createGain();
      oscillator.connect(gainNode);
      gainNode.connect(audioContext.destination);
      oscillator.type = 'sine';
      oscillator.frequency.value = 880;
      gainNode.gain.setValueAtTime(0.0001, audioContext.currentTime);
      gainNode.gain.exponentialRampToValueAtTime(0.08, audioContext.currentTime + 0.02);
      gainNode.gain.exponentialRampToValueAtTime(0.0001, audioContext.currentTime + 0.18);
      oscillator.start();
      oscillator.stop(audioContext.currentTime + 0.2);
    } catch (e) {
      console.warn('Chat beep failed', e);
    }
  }

  function updateTopbarBadge(count) {
    if (!chatToggle) return;
    let badge = chatToggle.querySelector('.badge');
    if (count > 0) {
      if (!badge) {
        badge = document.createElement('span');
        badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
        chatToggle.appendChild(badge);
      }
      badge.textContent = count > 99 ? '99+' : String(count);
    } else if (badge) {
      badge.remove();
    }
  }

  function renderContacts(contacts, selectedContact) {
    contactsEl.innerHTML = '';

    if (!contacts.length) {
      contactsEl.innerHTML = '<div class="text-muted small">No contacts available to chat with right now.</div>';
      return;
    }

    contacts.forEach(contact => {
      const item = document.createElement('button');
      item.type = 'button';
      item.className = `btn btn-light border text-start w-100 chat-contact-item ${selectedContact && selectedContact.id === contact.id ? 'active' : ''}`;
      item.innerHTML = `
        <div class="d-flex justify-content-between align-items-start gap-2">
          <div class="d-flex align-items-center gap-2">
            ${chatAvatar(contact, 38)}
            <div>
              <div class="fw-semibold">${escapeHtml(contact.name)}</div>
              <div class="small text-muted">${escapeHtml(contact.email)}</div>
            </div>
          </div>
          ${contact.unread_count > 0 ? `<span class="badge bg-danger rounded-pill">${contact.unread_count > 99 ? '99+' : contact.unread_count}</span>` : ''}
        </div>
      `;
      item.addEventListener('click', function () {
        selectedUserId = contact.id;
        loadChatData();
      });
      contactsEl.appendChild(item);
    });
  }

  function renderMessages(messages) {
    if (!messages.length) {
      messagesEl.innerHTML = '<div class="h-100 d-flex align-items-center justify-content-center text-muted">No messages yet. Start typing below.</div>';
      return;
    }

    messagesEl.innerHTML = messages.map(message => `
      <div class="d-flex mb-3 ${message.mine ? 'justify-content-end' : 'justify-content-start'}">
        ${message.mine ? '' : `<span class="me-2 mt-1">${chatAvatar(message, 30)}</span>`}
        <div class="chat-message-bubble ${message.mine ? 'chat-message-mine' : 'chat-message-other'}">
          <div class="small ${message.mine ? 'text-white-50' : 'text-muted'} mb-1">${message.mine ? 'You' : message.sender_name}</div>
          <div style="white-space: pre-wrap;">${String(message.message)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')}</div>
          <div class="small mt-2 ${message.mine ? 'text-white-50' : 'text-muted'}">${message.created_at || ''}</div>
        </div>
        ${message.mine ? `<span class="ms-2 mt-1">${chatAvatar(message, 30)}</span>` : ''}
      </div>
    `).join('');

    messagesEl.scrollTop = messagesEl.scrollHeight;

    const latest = messages[messages.length - 1];
    if (latest && latest.id > lastMessageId) {
      if (lastMessageId !== 0 && !latest.mine) {
        playBeep();
      }
      lastMessageId = latest.id;
    }
  }

  async function loadChatData() {
    try {
      const url = new URL(window.location.origin + dataUrl);
      if (selectedUserId) {
        url.searchParams.set('user', selectedUserId);
      }

      const response = await fetch(url.toString(), {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('Failed to load chat data');
      }

      const data = await response.json();
      if (data.selected_contact) {
        selectedUserId = data.selected_contact.id;
        recipientIdEl.value = data.selected_contact.id;
        selectedContactEl.innerHTML = `<div class="d-flex align-items-center gap-2">${chatAvatar(data.selected_contact, 38)}<div><div class="fw-semibold text-dark">${escapeHtml(data.selected_contact.name)}</div><div class="small text-muted">${escapeHtml(data.selected_contact.email)}</div></div></div>`;
      } else {
        selectedContactEl.textContent = 'No contact selected.';
        recipientIdEl.value = '';
      }

      renderContacts(data.contacts || [], data.selected_contact || null);
      renderMessages(data.messages || []);

      if ((data.chat_unread_count || 0) > lastUnreadCount && !isDrawerOpen) {
        playBeep();
      }

      lastUnreadCount = data.chat_unread_count || 0;
      updateTopbarBadge(lastUnreadCount);
    } catch (error) {
      console.error(error);
      selectedContactEl.textContent = 'Imeshindikana kupakia chat.';
    }
  }

  async function sendMessage(event) {
    event.preventDefault();
    const message = messageInputEl.value.trim();
    const recipientId = recipientIdEl.value;

    if (!message || !recipientId) {
      return;
    }

    try {
      const response = await fetch(sendUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrf,
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
          recipient_id: recipientId,
          message
        })
      });

      if (!response.ok) {
        throw new Error('Failed to send message');
      }

      messageInputEl.value = '';
      await loadChatData();
    } catch (error) {
      console.error(error);
      alert('Imeshindikana kutuma ujumbe. Jaribu tena.');
    }
  }

  function startPolling() {
    stopPolling();
    pollTimer = window.setInterval(loadChatData, 7000);
  }

  function stopPolling() {
    if (pollTimer) {
      window.clearInterval(pollTimer);
      pollTimer = null;
    }
  }

  drawer.addEventListener('shown.bs.offcanvas', function () {
    isDrawerOpen = true;
    loadChatData();
    startPolling();
  });

  drawer.addEventListener('hidden.bs.offcanvas', function () {
    isDrawerOpen = false;
    stopPolling();
  });

  formEl.addEventListener('submit', sendMessage);

  loadChatData();
  startPolling();
});
