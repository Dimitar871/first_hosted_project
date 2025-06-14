@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-semibold mb-4">Profile</h1>

    <p class="text-gray-700">
        You are logged in as  
        <span class="font-medium">{{ auth()->user()->email }}</span>
    </p>
</div>
@endsection
