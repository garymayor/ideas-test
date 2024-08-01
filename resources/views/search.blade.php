
<form method="POST" action="{{ route('search') }}">
    @csrf

    <input type="text" name="query" placeholder="Search...">
    <button type="submit">Search</button>
</form>
