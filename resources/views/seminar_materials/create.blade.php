<!DOCTYPE html>
<html>
<head>
    <title>Add Seminar Material</title>
</head>
<body>
    <h1>Add Seminar Material</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('seminar_materials.store') }}" method="POST">
        @csrf
        
        <label>File Path:</label>
        <input type="text" name="file_path" value="{{ old('file_path') }}">
        <br>
        <label>Description:</label>
        <input type="text" name="description" value="{{ old('description') }}">
        <br>
        <button type="submit">Add Material</button>
    </form>

    <a href="{{ route('seminar_materials.index') }}">Back to List</a>
</body>
</html>
