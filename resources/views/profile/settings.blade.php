@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur
              border border-gray-200/70 dark:border-gray-800/70 shadow-sm px-3 sm:px-4 py-2">
    <ol class="flex items-center flex-wrap gap-1.5 text-xs sm:text-sm text-gray-600 dark:text-gray-300">
      <li>
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold text-gray-900 dark:text-gray-100">PostPit</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </li>
      <li>
        <a href="{{ route('profile.show', auth()->user()) }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold">Profile</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Settings</li>
    </ol>
  </nav>

  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10 opacity-70">
      <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full blur-3xl bg-gradient-to-br from-yellow-300/40 to-orange-400/30 dark:from-yellow-500/25 dark:to-orange-400/20"></div>
      <div class="absolute -bottom-28 -left-20 h-80 w-80 rounded-full blur-3xl bg-gradient-to-tr from-white/40 to-yellow-200/40 dark:from-gray-800/40 dark:to-yellow-500/20"></div>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
      <div class="max-w-2xl space-y-2">
        <div class="inline-flex items-center gap-2">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Account</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                   bg-clip-text text-transparent bg-gradient-to-b
                   from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          Settings
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
          Update your profile details and manage your account.
        </p>
      </div>

      <div class="flex items-center gap-2 md:self-start">
        <a href="{{ route('profile.show', auth()->user()) }}"
           class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                  focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
          </svg>
          Back
        </a>
      </div>
    </div>
  </header>

  <section
    class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
           border border-gray-200/70 dark:border-gray-800/70 shadow-[0_16px_44px_-22px_rgba(0,0,0,0.45)]
           p-4 sm:p-6 space-y-4 sm:space-y-6">
    <form id="updateProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
      @csrf
      @method('patch')

      <div>
        <x-input-label for="name" value="Name" class="text-gray-900 dark:text-gray-100" />
        <x-text-input id="name" name="name" value="{{ old('name', $user->name) }}"
          class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-700
                 bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100 placeholder-gray-400
                 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm" />
      </div>

      <div>
        <x-input-label for="profile_photo" value="Profile Photo" class="text-gray-900 dark:text-gray-100" />
        <label for="profile_photo"
          class="inline-flex items-center gap-2 rounded-full px-4 sm:px-5 py-2.5
                 border border-gray-300 dark:border-gray-700
                 bg-white/70 dark:bg-gray-800/60 backdrop-blur-sm
                 text-gray-900 dark:text-gray-100 cursor-pointer
                 hover:bg-gray-100 dark:hover:bg-gray-700 transition
                 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2" />
          </svg>
          <span id="fileName" class="truncate">Choose a file</span>
        </label>
        <input type="file" name="profile_photo" id="profile_photo" class="hidden" />
        <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mt-1">Select a profile photo (optional).</p>
      </div>

      <div class="flex">
        <button type="submit"
                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-full
                       text-sm font-semibold tracking-tight
                       bg-yellow-400 text-gray-900
                       hover:bg-yellow-500 active:bg-yellow-500/90
                       dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:active:bg-yellow-400/90
                       border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                       focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15M12 4.5v15"/>
          </svg>
          <span>Update Profile</span>
        </button>
      </div>
    </form>
  </section>

  <section
    class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
           border border-gray-200/70 dark:border-gray-800/70 shadow-[0_16px_44px_-22px_rgba(0,0,0,0.45)]
           p-4 sm:p-6 space-y-3 sm:space-y-4">
    <p class="text-gray-700 dark:text-gray-300 text-sm sm:text-base">
      <span class="font-semibold text-gray-900 dark:text-gray-100">Warning:</span>
      Deleting your account is permanent. All your posts, comments, and data will be removed.
    </p>

    <button id="deleteAccountBtn"
            class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-full
                   text-sm font-semibold
                   bg-red-500 text-white
                   hover:bg-red-600 active:bg-red-600/90
                   border border-red-400/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                   focus:outline-none focus:ring-2 focus:ring-red-400 dark:focus:ring-red-600">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
      <span>Delete Account</span>
    </button>
  </section>

  <div id="validationModal"
       class="fixed inset-0 bg-black/40 dark:bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center px-2">
    <div class="bg-white dark:bg-gray-900 p-4 sm:p-6 rounded-2xl shadow-2xl
                w-[calc(100%-1.5rem)] max-w-[22rem] sm:max-w-lg space-y-3 sm:space-y-4 relative
                border border-gray-200 dark:border-gray-800">
      <button id="closeModal"
              class="absolute top-2.5 right-2.5 inline-flex items-center justify-center w-8 h-8 rounded-full
                     bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300
                     hover:bg-gray-200 dark:hover:bg-gray-700 transition"
              aria-label="Close modal">&times;</button>

      <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100" id="modalTitle">Notice</h2>

      <ul id="errorList" class="list-disc pl-5 text-gray-900 dark:text-gray-100 space-y-1 text-sm sm:text-base"></ul>

      <div id="deletePasswordDiv" class="hidden mt-1">
        <input type="password" id="deletePassword" placeholder="Password"
               class="w-full px-3 py-2 rounded-xl border border-gray-300 dark:border-gray-700
                      bg-white dark:bg-gray-950/70 text-gray-900 dark:text-gray-100
                      focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600" />
        <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mt-1">Enter your password to confirm deletion.</p>
      </div>

      <div id="modalSubmit" class="flex flex-col sm:flex-row sm:justify-end gap-2 mt-1 hidden">
        <button id="modalCancelBtn"
                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-full
                       text-sm font-semibold
                       bg-white/70 dark:bg-gray-900/60 backdrop-blur
                       text-gray-900 dark:text-gray-100
                       border border-gray-300/70 dark:border-gray-700/80
                       shadow-sm hover:shadow-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          Cancel
        </button>
        <button id="modalConfirmBtn"
                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-full
                       text-sm font-semibold
                       bg-red-500 text-white
                       hover:bg-red-600 active:bg-red-600/90
                       border border-red-400/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                       focus:outline-none focus:ring-2 focus:ring-red-400 dark:focus:ring-red-600">
          Confirm
        </button>
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
  const fileName  = document.getElementById('fileName');
  fileInput?.addEventListener('change', () => {
    fileName.textContent = fileInput.files?.length ? fileInput.files[0].name : 'Choose a file';
  });

  const updateForm = document.getElementById('updateProfileForm');
  const nameInput  = document.getElementById('name');

  updateForm?.addEventListener('submit', function(e) {
    const errors = [];
    nameInput.classList.remove('ring-2','ring-red-500','border-red-600');

    if (!nameInput.value.trim()) {
      errors.push("Name is required.");
      nameInput.classList.add('ring-2','ring-red-500','border-red-600');
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
      document.getElementById('modalTitle').textContent = 'Please fix the following:';
      document.getElementById('deletePasswordDiv').classList.add('hidden');
      document.getElementById('modalSubmit').classList.add('hidden');
      const m = document.getElementById('validationModal');
      m.classList.remove('hidden'); m.classList.add('flex');
    }
  });

  const deleteBtn            = document.getElementById('deleteAccountBtn');
  const deleteForm           = document.getElementById('deleteAccountForm');
  const hiddenDeletePassword = document.getElementById('hiddenDeletePassword');
  const modalConfirmBtn      = document.getElementById('modalConfirmBtn');
  const modalCancelBtn       = document.getElementById('modalCancelBtn');
  const errorList            = document.getElementById('errorList');
  const deletePasswordDiv    = document.getElementById('deletePasswordDiv');
  const deletePasswordInput  = document.getElementById('deletePassword');

  deleteBtn?.addEventListener('click', () => {
    errorList.innerHTML = '';
    document.getElementById('modalTitle').textContent = 'Delete Account';
    deletePasswordDiv.classList.remove('hidden');
    document.getElementById('modalSubmit').classList.remove('hidden');
    const m = document.getElementById('validationModal');
    m.classList.remove('hidden'); m.classList.add('flex');
  });

  modalConfirmBtn?.addEventListener('click', () => {
    if (!deletePasswordInput.value.trim()) {
      alert('Password is required.');
      return;
    }
    hiddenDeletePassword.value = deletePasswordInput.value.trim();
    deleteForm.submit();
  });

  modalCancelBtn?.addEventListener('click', () => {
    const m = document.getElementById('validationModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    deletePasswordInput.value = '';
  });

  document.getElementById('closeModal')?.addEventListener('click', function() {
    const m = document.getElementById('validationModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    deletePasswordInput.value = '';
  });

  @if(session('status'))
  document.addEventListener('DOMContentLoaded', () => {
    errorList.innerHTML = '';
    const li = document.createElement('li');
    li.textContent = @json(session('status'));
    errorList.appendChild(li);
    document.getElementById('modalTitle').textContent = 'Success';
    document.getElementById('deletePasswordDiv').classList.add('hidden');
    document.getElementById('modalSubmit').classList.add('hidden');
    const modal = document.getElementById('validationModal');
    modal.classList.remove('hidden'); modal.classList.add('flex');
    setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); }, 1200);
  });
  @endif
</script>
@endsection
