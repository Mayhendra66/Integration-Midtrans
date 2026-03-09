<h1>Dashboard</h1>

<p>Selamat datang {{ auth()->user()->name }}</p>

<form method="POST" action="/logout">
@csrf
<button type="submit">Logout</button>
</form>