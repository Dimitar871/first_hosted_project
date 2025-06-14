<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <span class="font-bold">My App</span>
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="/tasks" class="text-sm text-gray-700 hover:text-gray-900">Tasks</a>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="text-sm text-gray-700">{{ Auth::user()->name }}</div>
                @endauth
            </div>
        </div>
    </div>
</nav>