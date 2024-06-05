<!DOCTYPE html>
<html>
<head>
    <title>Seminar Materials</title>
</head>
<body>
    <h1>Seminar Materials</h1>

    <a href="{{ route('seminar_materials.create') }}">Add New Material</a>

    @if ($message = Session::get('success'))
        <p>{{ $message }}</p>
    @endif

    <table>
        <tr>
            <th>ID</th>
            <th>Seminar ID</th>
            <th>File Path</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        @foreach ($seminarMaterials as $material)
            <tr>
                <td>{{ $material->material_id }}</td>
                <td>{{ $material->seminar_id }}</td>
                <td>{{ $material->file_path }}</td>
                <td>{{ $material->description }}</td>
                <td>
                    <a href="{{ route('seminar_materials.show', $material->material_id) }}">View</a>
                    <a href="{{ route('seminar_materials.edit', $material->material_id) }}">Edit</a>
                    <form action="{{ route('seminar_materials.destroy', $material->material_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
