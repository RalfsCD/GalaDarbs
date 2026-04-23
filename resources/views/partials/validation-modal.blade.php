@php
  $modalId = $modalId ?? 'validationModal';
  $modalTitle = $modalTitle ?? 'Please fix the following:';
  $modalErrors = $modalErrors ?? [];
  $openOnLoad = $openOnLoad ?? false;
@endphp

<div id="{{ $modalId }}"
     data-validation-modal
     data-open-on-load="{{ $openOnLoad ? '1' : '0' }}"
     class="fixed inset-0 hidden items-center justify-center z-50 bg-black/45 dark:bg-black/70 backdrop-blur-sm px-4 py-6">
  <div class="relative w-full max-w-lg rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-2xl p-6 sm:p-7">
    <button type="button"
            data-validation-modal-close
            class="absolute right-3 top-3 inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
            aria-label="Close validation message">
      &times;
    </button>

    <div class="flex items-start gap-3 pr-8">
      <div class="mt-0.5 shrink-0 text-red-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M4.93 4.93l14.14 14.14M12 3a9 9 0 1 1 0 18 9 9 0 0 1 0-18z"/>
        </svg>
      </div>

      <div class="min-w-0">
        <h2 class="text-base font-bold text-gray-900 dark:text-gray-100">{{ $modalTitle }}</h2>
        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-gray-700 dark:text-gray-200">
          @foreach ($modalErrors as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-validation-modal][data-open-on-load="1"]').forEach((modal) => {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    });

    document.querySelectorAll('[data-validation-modal-close]').forEach((button) => {
      button.addEventListener('click', () => {
        const modal = button.closest('[data-validation-modal]');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      });
    });
  });
</script>