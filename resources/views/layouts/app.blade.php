<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard — Integrate Midtrans</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex">



{{-- sidebar --}}
@include('components.sidebar')




@yield('content')



  <script>
    function updateTime() {
      const now = new Date();
      document.getElementById('datetime').textContent = now.toLocaleDateString('en-US', { weekday:'short', month:'short', day:'numeric' }) + ' · ' + now.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit' });
    }
    updateTime();
    setInterval(updateTime, 1000);
  </script>

</body>
</html>

</html>