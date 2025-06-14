@extends('layouts.app')

@section('content')
    <h1>Tasks</h1>
    <a href="{{ route('tasks.create') }}">Create Task</a>
    <ul>
        @foreach ($tasks as $task)
            <li>
                <strong>{{ $task->title }}</strong><br>
                {{ $task->description }}
                <br><br>
                <a href="{{ route('tasks.edit', $task) }}">Edit</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
