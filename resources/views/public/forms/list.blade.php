<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <nav class="flex justify-start flex-1 px-6 mt-5 -mx-3">
        @auth
            <a href="{{ url('/dashboard') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Log in
            </a>
        @endauth
    </nav>
    <div class="px-6 py-12">
        <div class="px-8 mx-auto max-w-7xl">
            @if (session()->has('success'))
                <div class="relative px-4 py-3 mb-4 text-white bg-green-500" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if ($forms->isEmpty())
                <p class="text-center text-gray-500">No data found</p>
            @else
            <table class="table w-full mt-3 border border-collapse border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $form)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-2 text-left">
                                <a href="{{ route('public.forms.show', $form) }}" class="text-blue-500 hover:underline">
                                    {{ $form->name }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</body>

</html>
