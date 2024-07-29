<!DOCTYPE html>
<html>

<head>
    <title>Create Post</title>
</head>

<body>
    <h1>Create new post</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        <br>

        <label for="content">Content</label>
        <textarea id="content" name="content" required>{{ old('content') }}</textarea>
        <br>

        <button type="submit">Create Post</button>
    </form>
</body>
</html>
