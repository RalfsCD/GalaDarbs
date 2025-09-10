@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-6">
    @include('partials.post', ['post' => $post])
</div>

@include('partials.post-scripts')
@endsection
