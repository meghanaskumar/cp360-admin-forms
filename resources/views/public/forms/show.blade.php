<!DOCTYPE html>
<html>

<head>
    <title>{{ $form->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container p-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold">{{ $form->name }}</h1>

        @if (session('success'))
            <div class="px-4 py-3 mb-6 text-white bg-green-500 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('public.forms.submit', $form) }}" class="p-6 bg-white rounded shadow-md">
            @csrf

            @foreach ($form->fields as $field)
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700">{{ $field->label }}</label>

                    @if ($field->type === 'text')
                        <input type="text" name="fields[{{ $field->id }}]" required
                            class="w-full px-3 py-2 border border-gray-300 rounded">
                    @elseif ($field->type === 'number')
                        <input type="number" name="fields[{{ $field->id }}]" required
                            class="w-full px-3 py-2 border border-gray-300 rounded">
                    @elseif ($field->type === 'select')
                        <select name="fields[{{ $field->id }}]" required
                            class="w-full px-3 py-2 border border-gray-300 rounded">
                            @foreach ($field->options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endforeach

            <div class="flex justify-between">
                <a href="{{ route('public.forms.index') }}"
                    class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">Back</a>
                <button type="submit"
                    class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>
