const baseUrl = window.AppConfig?.baseUrl || window.location.origin;

function showToast(message, type = 'success') {
    const toastEl = document.getElementById('appToast');
    if (!toastEl) return;

    toastEl.classList.remove('success', 'error');
    toastEl.classList.add(type);
    toastEl.querySelector('.toast-body').textContent = message;
    bootstrap.Toast.getOrCreateInstance(toastEl).show();
}

document.addEventListener('DOMContentLoaded', () => {
    const flash = document.querySelector('.server-flash');
    if (flash) {
        showToast(flash.dataset.message, flash.dataset.type);
    }

    const postForm = document.getElementById('createPostForm');
    if (postForm) {
        postForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const button = postForm.querySelector('button');
            const spinner = postForm.querySelector('.spinner-border');
            button.disabled = true;
            spinner.classList.remove('d-none');

            const response = await fetch(`${baseUrl}/posts/create`, {
                method: 'POST',
                body: new FormData(postForm),
            });
            const data = await response.json();

            showToast(data.message, data.status);
            button.disabled = false;
            spinner.classList.add('d-none');

            if (data.status === 'success') {
                postForm.reset();
                setTimeout(() => window.location.reload(), 700);
            }
        });
    }

    document.querySelectorAll('.follow-btn').forEach((button) => {
        button.addEventListener('click', async () => {
            const userId = button.dataset.userId;
            button.disabled = true;

            const response = await fetch(`${baseUrl}/follow/${userId}`, { method: 'POST' });
            const data = await response.json();

            if (data.status === 'success') {
                button.textContent = data.following ? 'Unfollow' : 'Follow';
                const count = document.getElementById('followersCount');
                if (count) count.textContent = data.followers_count;
                showToast(data.following ? 'You are now following this user.' : 'You unfollowed this user.');

                if (button.dataset.removeRow === 'true' && !data.following) {
                    const row = button.closest('.person-row');
                    if (row) {
                        const list = row.parentElement;
                        row.remove();
                        if (list && !list.querySelector('.person-row')) {
                            list.insertAdjacentHTML('beforeend', '<div class="empty-state">No users to display.</div>');
                        }
                    }
                }
            } else {
                showToast(data.message, 'error');
            }

            button.disabled = false;
        });
    });

    document.querySelectorAll('.like-btn').forEach((button) => {
        button.addEventListener('click', async () => {
            const response = await fetch(`${baseUrl}/posts/like/${button.dataset.id}`, { method: 'POST' });
            const data = await response.json();
            button.querySelector('span').textContent = data.likes_count;
            button.classList.toggle('btn-primary', data.liked);
            button.classList.toggle('btn-light', !data.liked);
        });
    });

    document.querySelectorAll('.delete-post-btn').forEach((button) => {
        button.addEventListener('click', async () => {
            if (!confirm('Delete this post?')) {
                return;
            }

            button.disabled = true;
            const response = await fetch(`${baseUrl}/posts/delete/${button.dataset.id}`, { method: 'POST' });
            const data = await response.json();
            showToast(data.message, data.status);

            if (data.status === 'success') {
                button.closest('.post-card').remove();
            } else {
                button.disabled = false;
            }
        });
    });

    document.querySelectorAll('.comment-form').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const input = form.querySelector('input');
            const response = await fetch(`${baseUrl}/posts/comment/${form.dataset.id}`, {
                method: 'POST',
                body: new FormData(form),
            });
            const data = await response.json();
            showToast(data.message, data.status);
            if (data.status === 'success') {
                input.value = '';
                setTimeout(() => window.location.reload(), 500);
            }
        });
    });

    document.querySelectorAll('.share-btn').forEach((button) => {
        button.addEventListener('click', () => showToast('Share button UI is ready for future expansion.'));
    });

    const imageInput = document.getElementById('profilePictureInput');
    const preview = document.getElementById('imagePreview');
    if (imageInput && preview) {
        imageInput.addEventListener('change', () => {
            const file = imageInput.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });
    }

    const navSearch = document.getElementById('navSearch');
    const suggestions = document.getElementById('searchSuggestions');
    let searchTimer = null;

    if (navSearch && suggestions) {
        navSearch.addEventListener('input', () => {
            clearTimeout(searchTimer);
            const query = navSearch.value.trim();

            if (query.length < 2) {
                suggestions.style.display = 'none';
                suggestions.innerHTML = '';
                return;
            }

            searchTimer = setTimeout(async () => {
                const response = await fetch(`${baseUrl}/search/suggestions?q=${encodeURIComponent(query)}`);
                const users = await response.json();
                suggestions.innerHTML = users.map((user) => `
                    <a class="suggestion-item" href="${baseUrl}/profile/${user.id}">
                        <img src="${user.profile_picture === 'default.png' ? window.AppConfig.defaultAvatar : `${baseUrl}/profile-picture/${user.profile_picture}`}" alt="">
                        <div><strong>${escapeHtml(user.username)}</strong><small class="d-block text-muted">${escapeHtml(user.first_name)} ${escapeHtml(user.last_name)}</small></div>
                    </a>
                `).join('');
                suggestions.style.display = users.length ? 'block' : 'none';
            }, 250);
        });
    }
});

function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, (character) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;',
    }[character]));
}
