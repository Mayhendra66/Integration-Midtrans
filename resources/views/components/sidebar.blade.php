<aside class="w-64 bg-white border-r border-gray-100 min-h-screen flex flex-col fixed left-0 top-0">

    <!-- Logo -->
    <div class="flex items-center gap-2 px-6 py-5 border-b border-gray-100">
      <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center shrink-0">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
      </div>
      <span class="text-base font-bold text-gray-800">Integrate <span class="text-blue-600">Midtrans</span></span>
    </div>

    <!-- Nav -->
<nav class="flex-1 px-4 py-6 space-y-1">

  <!-- Dashboard -->
  <a href="{{ route('dashboard') }}"
     class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
     {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">

      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7" rx="1"/>
        <rect x="14" y="3" width="7" height="7" rx="1"/>
        <rect x="3" y="14" width="7" height="7" rx="1"/>
        <rect x="14" y="14" width="7" height="7" rx="1"/>
      </svg>

      Dashboard
  </a>


  <!-- Categories -->
  <a href="{{ route('categories') }}"
     class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
     {{ request()->routeIs('categories*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">

      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M4 6h16M4 12h16M4 18h7"/>
      </svg>

      Categories
  </a>


  <!-- Products -->
  <a href="{{ route('products') }}"
     class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
     {{ request()->routeIs('products*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">

      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 01-8 0"/>
      </svg>

      Products
  </a>


  <!-- Payment -->
  <a href="{{ route('payment') }}"
     class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
     {{ request()->routeIs('payment*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">

      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="2" y="5" width="20" height="14" rx="2"/>
        <path d="M2 10h20"/>
      </svg>

      Payment
  </a>

</nav>

    <!-- User -->
    <div class="px-4 py-4 border-t border-gray-100">
      <div class="flex items-center gap-3 px-3 py-2">
        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
          <span class="text-blue-600 font-semibold text-xs">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
          <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
        </div>
      </div>

      <form method="POST" action="/logout" class="mt-2">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-500 hover:bg-red-50 font-medium text-sm transition">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Logout
        </button>
      </form>
    </div>

  </aside>