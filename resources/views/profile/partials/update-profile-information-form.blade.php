{{-- Profile Photo --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Profile Photo</label>

    <p class="text-xs text-gray-500 mb-2">
        Logged in as: {{ auth()->id() }} - {{ auth()->user()->email }}
    </p>

    <div class="mt-2">
        <img
            id="photoPreview"
            class="h-24 w-24 rounded-full object-cover border"
            src="{{ $user->profile_photo
                ? '/profile_photos/' . rawurlencode($user->profile_photo) . '?t=' . time()
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=e5e7eb&color=111827&size=160'
            }}"
            alt="Profile Photo"
            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=e5e7eb&color=111827&size=160';"
        >
    </div>

    <input
        type="file"
        name="profile_photo"
        accept="image/*"
        class="mt-2 block w-full"
        onchange="uploadPhoto(this)"
    >

    <p id="uploadStatus" class="text-sm mt-1 hidden"></p>
</div>

<script>
function uploadPhoto(input) {
    const file = input.files[0];
    if (!file) return;

    const status = document.getElementById('uploadStatus');
    const photo = document.getElementById('photoPreview');

    if (!photo) {
        console.error('photoPreview element not found');
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        photo.src = e.target.result;
    };
    reader.readAsDataURL(file);

    const formData = new FormData();
    formData.append('profile_photo', file);
    formData.append('_token', '{{ csrf_token() }}');

    status.textContent = 'Uploading...';
    status.className = 'text-blue-600 text-sm mt-1';

    fetch('{{ route("profile.photo.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(async response => {
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Upload failed');
        }

        return data;
    })
    .then(data => {
        if (data.success && data.filename) {
            photo.src = '/profile_photos/' + encodeURIComponent(data.filename) + '?t=' + new Date().getTime();
            status.textContent = 'Profile photo updated for user ' + (data.user_id ?? '');
            status.className = 'text-green-600 text-sm mt-1';
        } else {
            throw new Error('Upload failed');
        }
    })
    .catch(error => {
        console.error(error);
        status.textContent = error.message || 'Upload failed!';
        status.className = 'text-red-600 text-sm mt-1';
    });
}
</script>