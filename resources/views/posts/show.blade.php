@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-6">

    {{-- Single Post Card --}}
    @include('partials.post', ['post' => $post])

</div>

{{-- Same AJAX scripts (like, delete, comment) --}}
@include('partials.post-scripts')
@endsection
