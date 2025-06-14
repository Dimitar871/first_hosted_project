@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Create New Task</h1>

    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block font-medium">Title</label>
            <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" required value="{{ old('title') }}">
            @error('title')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Task</button>
    </form>
</div>
@endsection
