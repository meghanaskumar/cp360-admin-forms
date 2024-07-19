
<!-- resources/views/forms/show.blade.php -->

<x-app-layout>

@section('content')
<div class="container">
    <h1>{{ $form->name }}</h1>
    <form action="{{ route('forms.submit', $form) }}" method="POST">
        @csrf
        @foreach ($form->fields as $field)
            <div class="mb-3">
                <label for="field-{{ $field->id }}">{{ $field->label }}</label>
                @if ($field->type == 'text')
                    <input type="text" name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control">
                @elseif ($field->type == 'textarea')
                    <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control"></textarea>
                @elseif ($field->type == 'select')
                    <select name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control">
                        @foreach ($field->options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
</x-app-layout>

