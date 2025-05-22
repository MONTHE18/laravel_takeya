<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-10 sm:px-6 lg:px-8">

            {{-- for gueset users --}}
            @guest
                
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                    <a href="{{ route('register') }}" class="text-blue-500">register</a>.</p>
                </div>
            </div>
            @endguest

            {{-- for authenticated users --}}
            @auth
                
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-6 p-6">
                    <h2 class="text-lg font-semibold">Your Posts</h2>
                    @if ($posts->count())
            @foreach ($posts as $post)
            <div class="rounded-md border p-5 shadow mb-4">
                <div class="flex items-center gap-2">
                    @php
                        $isDraft = $post->is_draft;
                        $statusLabel = $isDraft ? 'Draft' : 'Published';
                        $statusClass = $isDraft ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                    @endphp
                    <span class="flex-none rounded px-2 py-1 {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                    <h3>
                        <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">{{ $post->title }}</a>
                    </h3>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <div>Published: {{ $post->created_at->format('Y-m-d') }}</div>
                        <div>Updated: {{ $post->updated_at->format('Y-m-d') }}</div>
                    </div>
                    <div>
                        <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">Detail</a> /
                        <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500">Edit</a> /
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
         @endforeach

        <!-- Pagination -->
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    @else
        <p>You have no posts yet.</p>
    @endif
                    {{-- <div class="rounded-md border p-5 shadow">
                        <div class="flex items-center gap-2">
                            <span class="flex-none rounded bg-gray-100 px-2 py-1 text-gray-800">Draft</span>
                            <h3><a href="#" class="text-blue-500">Post title 2</a></h3>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Published: -</div>
                                <div>Updated: 2024-10-10</div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500">Detail</a> /
                                <a href="#" class="text-blue-500">Edit</a> /
                                <form action="#" method="POST" class="inline">
                                    <button class="text-red-500">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-md border p-5 shadow">
                        <div class="flex items-center gap-2">
                            <span class="flex-none rounded bg-yellow-100 px-2 py-1 text-yellow-800">Scheduled</span>
                            <h3><a href="#" class="text-blue-500">Post title 3</a></h3>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Published: 2030-10-01</div>
                                <div>Updated: 2024-10-10</div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500">Detail</a> /
                                <a href="#" class="text-blue-500">Edit</a> /
                                <form action="#" method="POST" class="inline">
                                    <button class="text-red-500">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                    <div>Pagination Here</div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</x-app-layout>
