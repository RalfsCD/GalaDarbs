@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">Settings</h1>
    </div>

    {{-- Update Profile Form --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md border border-gray-200 dark:border-gray-700 hover:shadow-lg transition space-y-6">
        <form id="updateProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            {{-- Name Field --}}
            <div>
                <x-input-label for="name" value="Name" class="text-gray-900 dark:text-gray-100" />
                <x-text-input id="name" name="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600" />
            </div>

            {{-- Profile Photo --}}
            <div>
                <x-input-label for="profile_photo" value="Profile Photo" class="text-gray-900 dark:text-gray-100" />
                <label
                    for="profile_photo"
                    class="flex items-center justify-center w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2" />
                    </svg>
                    <span id="fileName" class="truncate">Choose a file</span>
                </label>
                <input type="file" name="profile_photo" id="profile_photo" class="hidden" />
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Select a profile photo (optional)</p>
            </div>

            <button type="submit"
                class="px-5 py-2.5 rounded-full bg-yellow-500 text-white font-bold border border-yellow-400 shadow-md hover:bg-yellow-600 hover:shadow-lg transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Update Profile</span>
            </button>
        </form>
    </div>

    {{-- Delete Account Section --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md space-y-4">
        <p class="text-gray-700 dark:text-gray-300 font-medium">
            Warning: Deleting your account is permanent and cannot be undone.
            All your posts, comments, and data will be permanently removed.
        </p>

        <button id="deleteAccountBtn"
            class="px-5 py-2.5 rounded-full bg-red-500 text-white font-bold border border-red-400 shadow-md hover:bg-red-600 hover:shadow-lg transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Delete Account</span>
        </button>
    </div>

    <!-- Profile Deletion Confirmation Modal -->
    <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg max-w-lg w-full space-y-4 relative">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-2xl">&times;</button>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100" id="modalTitle">Notice</h2>
            <ul id="errorList" class="list-disc pl-5 text-gray-900 dark:text-gray-100 space-y-1"></ul>

            <div id="deletePasswordDiv" class="hidden mt-2">
                <input type="password" id="deletePassword" placeholder="Password" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600" />
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Enter your password to confirm deletion.</p>
            </div>

            <div id="modalSubmit" class="flex justify-end mt-2 hidden">
                <button id="modalConfirmBtn" class="px-4 py-2 rounded-full bg-red-500 text-white font-bold hover:bg-red-600 transition">Confirm</button>
            </div>
        </div>
    </div>

    <form id="deleteAccountForm" method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')
        <input type="hidden" name="password" id="hiddenDeletePassword">
    </form>
</div>

<script>
    const fileInput = document.getElementById('profile_photo');
    const fileName = document.getElementById('fileName');

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
        } else {
            fileName.textContent = 'Choose a file';
        }
    });

    // --- Profile Update ---
    const updateForm = document.getElementById('updateProfileForm');
    const nameInput = document.getElementById('name');

    updateForm.addEventListener('submit', function(e) {
        const errors = [];
        nameInput.classList.remove('border-red-600');

        if (!nameInput.value.trim()) {
            errors.push("Name is required.");
            nameInput.classList.add('border-red-600');
        }

        if (errors.length > 0) {
            e.preventDefault();
            const errorList = document.getElementById('errorList');
            errorList.innerHTML = '';
            errors.forEach(err => {
                const li = document.createElement('li');
                li.textContent = err;
                errorList.appendChild(li);
            });
            document.getElementById('modalTitle').textContent = 'Please fix the following errors:';
            document.getElementById('deletePasswordDiv').classList.add('hidden');
            document.getElementById('modalSubmit').classList.add('hidden');
            document.getElementById('validationModal').classList.remove('hidden');
        }
    });

    // --- Profile Deletion ---
    const deleteBtn = document.getElementById('deleteAccountBtn');
    const deleteForm = document.getElementById('deleteAccountForm');
    const hiddenDeletePassword = document.getElementById('hiddenDeletePassword');
    const modalConfirmBtn = document.getElementById('modalConfirmBtn');
    const modalSubmitDiv = document.getElementById('modalSubmit');
    const errorList = document.getElementById('errorList');
    const deletePasswordDiv = document.getElementById('deletePasswordDiv');
    const deletePasswordInput = document.getElementById('deletePassword');

    deleteBtn.addEventListener('click', () => {
        errorList.innerHTML = '';
        document.getElementById('modalTitle').textContent = 'Delete Account';
        deletePasswordDiv.classList.remove('hidden');
        modalSubmitDiv.classList.remove('hidden');
        document.getElementById('validationModal').classList.remove('hidden');
    });

    modalConfirmBtn.addEventListener('click', () => {
        if (!deletePasswordInput.value.trim()) {
            alert('Password is required.');
            return;
        }
        hiddenDeletePassword.value = deletePasswordInput.value.trim();
        deleteForm.submit();
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('validationModal').classList.add('hidden');
        deletePasswordInput.value = '';
    });

    @if(session('status'))
    document.addEventListener('DOMContentLoaded', () => {
        errorList.innerHTML = '';
        const li = document.createElement('li');
        li.textContent = "{{ session('status') }}";
        errorList.appendChild(li);
        document.getElementById('modalTitle').textContent = 'Success';
        deletePasswordDiv.classList.add('hidden');
        modalSubmitDiv.classList.add('hidden');
        const modal = document.getElementById('validationModal');
        modal.classList.remove('hidden');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 1000);
    });
    @endif
</script>
@endsection
