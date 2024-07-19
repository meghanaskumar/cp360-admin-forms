<x-app-layout>
    @section('styles')
        <style>
            .bg-color {
                background-color: #e4e4ff !important;
            }

            .bg-color-green {
                background-color: #baeebb !important;
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
            {{ __('Edit Dynamic Form') }}
        </h2>
    </x-slot>

    <div class="px-6 py-12">
        <div class="px-8 mx-auto max-w-7xl">
            <div class="overflow-hidden">
                @if (session()->has('success'))
                    <div class="relative px-4 py-4 mb-4 rounded-lg bg-color-green" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('forms.update', $form) }}"
                    class="max-w-lg px-8 py-6 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap mb-4">
                        <div class="w-full px-2 mb-4 md:w-1/2 md:mb-0">
                            <label class="block mb-2 text-sm font-bold">Form Name:</label>
                            <input type="text" name="name" value="{{ $form->name }}"
                                class="w-full px-3 py-2 border rounded" placeholder="Name">
                        </div>
                    </div>

                    <div id="fields-container">
                        @foreach ($form->fields as $index => $field)
                            <div class="mb-4 field-row-{{ $index }}">
                                <div class="flex flex-wrap w-full">
                                    <div class="w-full px-2 mb-4">
                                        <label class="block mb-2 text-sm font-bold">Label:</label>
                                        <input type="text" name="fields[{{ $index }}][label]"
                                            value="{{ $field->label }}" class="w-full px-3 py-2 border rounded"
                                            placeholder="Label">
                                    </div>
                                    <div class="w-full px-2 mb-4">
                                        <label class="block mb-2 text-sm font-bold">Type:</label>
                                        <select name="fields[{{ $index }}][type]"
                                            class="w-full px-3 py-2 border rounded shadow field-type"
                                            data-index="{{ $index }}">
                                            <option value="text" @if ($field->type == 'text') selected @endif>
                                                Text
                                            </option>
                                            <option value="number" @if ($field->type == 'number') selected @endif>
                                                Number</option>
                                            <option value="select" @if ($field->type == 'select') selected @endif>
                                                Select</option>
                                        </select>
                                    </div>
                                    <div class="w-full px-2 mb-4">
                                        <div class="options-container"
                                            style="@if ($field->type != 'select') display: none; @endif"
                                            data-index="{{ $index }}">
                                            <label class="block mb-2 text-sm font-bold">Options:</label>
                                            @foreach ($field->options as $optionIndex => $option)
                                                <div class="option-item">
                                                    <input type="text"
                                                        name="fields[{{ $index }}][options][{{ $optionIndex }}]"
                                                        value="{{ $option }}" placeholder="Option"
                                                        class="w-full px-3 py-2 mb-2 border rounded">
                                                    <button type="button"
                                                        class="px-4 mt-2 font-bold rounded-lg remove-option bg-color-red"
                                                        data-index="{{ $index }}">-</button>
                                                </div>
                                            @endforeach
                                            <button type="button" class="px-4 mt-2 font-bold rounded-lg add-option bg-color-green"
                                                data-index="{{ $index }}">+</button>
                                        </div>
                                    </div>
                                    <div class="w-full px-2">
                                        <button type="button"
                                            class="px-4 py-2 mt-2 font-bold rounded-lg remove-field bg-color-red"
                                            data-index="{{ $index }}">Remove Field</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between">
                        <div>
                            <button type="button" id="add-field" class="px-4 py-2 mt-2 font-bold rounded-lg bg-color-green">+ Add
                                Field</button>
                            <button type="submit" class="px-4 py-2 mt-2 font-bold rounded-lg bg-color-blue">Update</button>
                        </div>
                        <div>
                            <a href="{{ route('forms.index') }}" class="px-4 py-2 mt-2 font-bold rounded-lg bg-color">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let index = {{ $form->fields->count() }};

            $('#add-field').click(function() {
                $('#fields-container').append(`
                    <div class="mb-4 field-row-${index}">
                        <div class="flex flex-wrap w-full">
                            <div class="w-full px-2 mb-4">
                                <label class="block mb-2 text-sm font-bold">Label:</label>
                                <input type="text" name="fields[${index}][label]" placeholder="Enter Field Name"
                                    class="w-full px-3 py-2 border rounded">
                            </div>
                            <div class="w-full px-2 mb-4">
                                <label class="block mb-2 text-sm font-bold">Type:</label>
                                <select name="fields[${index}][type]"
                                    class="w-full px-3 py-2 border rounded shadow field-type" data-index="${index}">
                                    <option value="text">Text</option>
                                    <option value="number">Number</option>
                                    <option value="select">Select</option>
                                </select>
                            </div>
                            <div class="w-full px-2 mb-4">
                                <div class="options-container" data-index="${index}" style="display: none;">
                                    <label class="block mb-2 text-sm font-bold">Options:</label>
                                    <div class="option-group" data-index="${index}">
                                        <div class="option-item">
                                            <input type="text" name="fields[${index}][options][]" placeholder="Option"
                                                class="w-full px-3 py-2 mt-2 border rounded">
                                            <button type="button" class="px-4 mt-2 font-bold rounded-lg remove-option bg-color-red"
                                                data-index="${index}">-</button>
                                        </div>
                                    </div>
                                    <button type="button" class="px-4 mt-2 font-bold rounded-lg add-option bg-color-green"
                                        data-index="${index}">+</button>
                                </div>
                            </div>
                            <div class="w-full px-2 mb-4">
                                <button type="button" class="px-4 py-2 mt-2 font-bold rounded-lg remove-field bg-color-red"
                                    data-index="${index}">Remove Field</button>
                            </div>
                        </div>
                    </div>
                `);
                index++;
            });

            $(document).on('change', '.field-type', function() {
                let index = $(this).data('index');
                if ($(this).val() === 'select') {
                    $(`.options-container[data-index="${index}"]`).show();
                } else {
                    $(`.options-container[data-index="${index}"]`).hide();
                }
            });

            $(document).on('click', '.add-option', function() {
                let index = $(this).data('index');
                $(this).before(`
                    <div class="option-item">
                        <input type="text" name="fields[${index}][options][]" placeholder="Option"
                            class="w-full px-3 py-2 mt-2 border rounded">
                        <button type="button" class="px-4 mt-2 font-bold rounded-lg remove-option bg-color-red"
                            data-index="${index}">-</button>
                    </div>
                `);
            });

            $(document).on('click', '.remove-field', function() {
                let fieldIndex = $(this).data('index');
                $(`.field-row-${fieldIndex}`).remove();
            });

            $(document).on('click', '.remove-option', function() {
                $(this).parent().remove();
            });
        });
    </script>
</x-app-layout>
