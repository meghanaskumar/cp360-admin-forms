<x-app-layout>
    @section('styles')
        <style>
            .bg-color {
                background-color: #e4e4ff !important;
            }

            .bg-color-red {
                background-color: #f9be9d !important;
            }

            .bg-color-blue {
                background-color: #88b2ec !important;
            }
        </style>
    @endsection
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Dynamic Forms') }}
        </h2>
    </x-slot>
    <div class="px-6 py-12">
        <div class="px-8 mx-auto max-w-7xl">
            @if (session('success'))
                <div class="px-4 py-3 mb-6 text-white bg-green-500 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <a href="{{ route('forms.create') }}" class="px-4 py-2 mt-2 font-bold rounded-full bg-color-blue">Create a
                form</a>
            @if ($forms->isEmpty())
                <p class="text-center text-gray-500">No data found</p>
            @else
                <table class="table w-full mt-3 border border-collapse border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forms as $form)
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 text-center">{{ $form->name }}</td>
                                <td class="px-4 py-2 text-center">
                                    <div class="flex justify-center">
                                        <a href="{{ route('forms.edit', $form) }}"
                                            class="inline-block px-3 py-1 mt-2 ml-2 font-bold rounded-lg bg-color">Edit</a>
                                        <form action="{{ route('forms.destroy', $form) }}" method="POST"
                                            class="inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 mt-2 ml-0.5 font-bold rounded-lg bg-color-red">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
        </div>
    </div>

</x-app-layout>
