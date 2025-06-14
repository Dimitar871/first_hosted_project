@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">All Tasks</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Create Task</a>

    <ul class="space-y-4">
        @forelse($tasks as $task)
            <li class="border p-4 rounded flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">{{ $task->title }}</h2>
                    <p class="text-gray-600">{{ $task->description }}</p>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 underline">Edit</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 underline">Delete</button>
                    </form>
                </div>
            </li>
        @empty
            <li class="text-gray-500">No tasks found.</li>
        @endforelse
    </ul>
</div>
@endsection
