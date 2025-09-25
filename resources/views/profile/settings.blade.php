@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex justify-center p-6 relative">


    <div class="w-full max-w-3xl bg-white/50 backdrop-blur-md border border-gray-200 rounded-3xl p-8 space-y-8">


        <h1 class="text-4xl font-extrabold text-gray-900">Settings</h1>

        {{-- Update Profile Form --}}
        <form id="updateProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('patch')


            <div>
                <x-input-label for="name" value="Name" class="text-gray-900" />
                <x-text-input id="name" name="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-300" />
            </div>


            <div>
                <x-input-label for="profile_photo" value="Profile Photo" class="text-gray-900" />
                <label
                    for="profile_photo"
                    class="flex items-center justify-center w-full px-3 py-2 rounded-lg border border-gray-300 bg-white/70 backdrop-blur-sm text-gray-900 cursor-pointer hover:bg-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2" />
                    </svg>
                    <span id="fileName" class="truncate">Choose a file</span>
                </label>
                <input type="file" name="profile_photo" id="profile_photo" class="hidden" />
                <p class="text-gray-500 text-sm mt-1">Select a profile photo (optional)</p>
            </div>

            <button type="submit"
                class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                Update Profile
            </button>
        </form>

        {{-- Delete Account --}}
        <div class="space-y-4">
            <p class="text-gray-700 font-medium">
                Warning: Deleting your account is permanent and cannot be undone.
                All your posts, comments, and data will be permanently removed.
            </p>

            <button id="deleteAccountBtn"
                class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                Delete Account
            </button>
        </div>
    </div>

    <!-- Profila dzēšana -->
    <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-lg w-full space-y-4 relative">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-xl font-bold text-gray-900" id="modalTitle">Notice</h2>
            <ul id="errorList" class="list-disc pl-5 text-gray-900 space-y-1"></ul>


            <div id="deletePasswordDiv" class="hidden mt-2">
                <input type="password" id="deletePassword" placeholder="Password" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300" />
                <p class="text-gray-500 text-sm mt-1">Enter your password to confirm deletion.</p>
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

    // --- Profila izmaiņas ---
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

    // --- Profila dzēšana ---
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