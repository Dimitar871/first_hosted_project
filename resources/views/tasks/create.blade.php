@extends('layouts.app')

@section('content')
    <h1>Create Task</h1>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description"></textarea>
        <button type="submit">Save</button>
    </form>
@endsection
