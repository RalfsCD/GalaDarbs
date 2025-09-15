@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">

    <h1 class="text-2xl font-bold mb-6">User Management</h1>

    <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition mb-4 inline-block">
        Back to Admin Dashboard
    </a>

    <table class="w-full border mt-2">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 text-left">ID</th>
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Email</th>
                <th class="p-2 text-left">Warnings</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t">
                    <td class="p-2">{{ $user->id }}</td>
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2">{{ $user->warnings->count() ?? 0 }}</td>
                    <td class="p-2">
                        @if(!$user->isAdmin())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Delete user?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
                            </form>
                        @else
                            <span class="text-gray-500 font-semibold">Admin</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
