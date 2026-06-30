<!-- Sidebar Kiri -->
      <div class="w-full lg:w-1/3 mb-8 lg:mb-0 lg:pr-8">
        <div class="sticky top-8">
          <!-- Breadcrumb -->
          <div class="flex items-center gap-2 mb-8 p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
            <a href="{{ url('home_page') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 text-sm font-medium">Home</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 text-sm font-medium">My Account</span>
          </div>

          <!-- Navigation Menu -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
              <h3 class="text-lg font-bold text-gray-900 mb-6">Account Settings</h3>
              
              <div class="space-y-6">
                <!-- Manage Account Section -->
                <div class="space-y-3">
                  <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Manage My Account</h4>
                  <div class="space-y-2 ml-4">
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 rounded-xl text-gray-600 hover:text-blue-600 hover:bg-gray-50 font-medium transition-all duration-200">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                      </svg>
                      My Profile
                    </a>
                    <a href="{{ route('change.password') }}" class="flex items-center gap-3 p-3 rounded-xl text-gray-600 hover:text-blue-600 hover:bg-gray-50 font-medium transition-all duration-200">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2m0 0V7a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                      </svg>
                      Change Password
                    </a>
                  </div>
                </div>
