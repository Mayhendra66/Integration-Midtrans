<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — Integrate Midtrans</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: 'Inter', sans-serif; }
    input:focus { outline: none; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- Main -->
  <div class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <!-- Header -->
        <div class="mb-8">
          <h1 class="text-2xl font-bold text-gray-800">Sign in to your account</h1>
          <p class="text-sm text-gray-500 mt-1">Manage your payment integrations</p>
        </div>

        @if(session('error'))
        <div class="mb-5 flex items-center gap-2 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="/login" class="space-y-5">
          @csrf

          <!-- Email -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
            <input
              type="email"
              name="email"
              placeholder="you@example.com"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm text-gray-800 placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
            />
          </div>

          <!-- Password -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label class="text-sm font-medium text-gray-700">Password</label>
              <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Forgot password?</a>
            </div>
            <input
              type="password"
              name="password"
              placeholder="Enter your password"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm text-gray-800 placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
            />
          </div>

          <!-- Submit -->
          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-sm py-3 rounded-xl transition"
          >
            Sign In
          </button>

          <!-- Divider -->
          <div class="flex items-center gap-3 my-1">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400">or</span>
            <div class="flex-1 h-px bg-gray-200"></div>
          </div>

          <!-- Google Login -->
          <button
            type="button"
            class="w-full flex items-center justify-center gap-3 border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium text-sm py-3 rounded-xl transition"
          >
            <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            Continue with Google
          </button>

        </form>
      </div>

      <!-- Register link -->
      <p class="text-center text-sm text-gray-500 mt-6">
        Don't have an account?
        <a href="{{ route('seed')}}" class="text-blue-600 hover:text-blue-700 font-semibold">Create one</a>
      </p>

    </div>
  </div>

</body>
</html>