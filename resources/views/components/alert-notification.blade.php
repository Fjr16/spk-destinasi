  {{-- alert --}}
  @if (session()->has('success'))
    <div class="alert alert-success d-flex mb-4" role="alert">
        <span class="alert-icon rounded-circle"><i class="bx bx-checklist"></i></span>
        <div class="d-flex flex-column ps-1">
        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Success</h6>
        <span>{{ session('success') }} !</span>
        </div>
    </div>
  @endif
  {{-- end alert --}}
  {{-- @props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400']) }}>
        {{ $status }}
    </div>
@endif --}}
{{-- end alert --}}