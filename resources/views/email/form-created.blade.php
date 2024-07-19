<!DOCTYPE html>
<html>
<head>
    <title>Form Created</title>
</head>
<body>
    <h1>A new form has been created!</h1>
    <p>Form Name: {{ $formName }}</p>
    <h2>Fields:</h2>
    <ul>
        @foreach ($formFields as $field)
            <li>{{ $field->label }} ({{ $field->type }})</li>
        @endforeach
    </ul>
</body>
</html>
