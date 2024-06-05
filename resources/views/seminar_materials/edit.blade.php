<!DOCTYPE html>
<html>
<head>
    <title>Edit Seminar Material</title>
</head>
<body>
    <h1>Edit Seminar Material</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('seminar_materials.update', $seminarMaterial->material_id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Seminar ID:</label>
        <input type="number" name="seminar_id" value="{{ $seminarMaterial->seminar_id }}">
        <br>
        <label>File Path:</label>
        <input type="text" name="file_path" value="{{ $seminarMaterial->file_path }}">
        <br>
        <label>Description:</label>
        <input type="text" name="description" value="{{ $seminarMaterial->description }}">
        <br>
        <button type="submit">Update Material</button>
    </form>

    <a href="{{ route('seminar_materials.index') }}">Back to List</a>
</body>
</html>
