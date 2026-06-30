<header class="sticky top-0 z-10 backdrop-blur-lg bg-gradient-to-r from-[#b0cee3]/95 to-[#a8c5dc]/95 border-b border-white/20 shadow-xl">
    <div class="flex justify-between items-center px-6 py-4 relative">

        <!-- Logo with Modern Gradient -->
        <div class="logo font-bold text-2xl bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent hover:scale-105 transition-transform duration-300 cursor-pointer">
            SEAPEDIA
        </div>

        <!-- Hamburger Menu Icon (mobile) with Animation -->
        <div class="md:hidden text-3xl cursor-pointer p-2 rounded-xl hover:bg-white/20 transition-all duration-300 transform hover:scale-110 active:scale-95" onclick="toggleMobileMenu()">
            <i class='bx bx-menu transition-transform duration-300' id="hamburger-icon"></i>
        </div>

        <!-- Desktop Menu with Glass Effect -->
        <nav class="menu hidden md:flex gap-2 items-center bg-white/10 backdrop-blur-sm rounded-2xl px-6 py-3 border border-white/20">
            <a href="{{ route('home_page') }}" class="nav-link text-gray-800 text-base hover:text-white font-medium px-4 py-2 rounded-xl transition-all duration-300 hover:bg-white/20 hover:shadow-lg transform hover:-translate-y-0.5">
                Home
            </a>
            <a href="{{ route('chat.index') }}" class="nav-link text-gray-800 text-base hover:text-white font-medium px-4 py-2 rounded-xl transition-all duration-300 hover:bg-white/20 hover:shadow-lg transform hover:-translate-y-0.5">
                Contact
            </a>

            <!-- Modern Dropdown Categories -->
            <div id="categoryDropdownContainer" class="relative">
                <button
                    id="categoryDropdownBtn"
                    tabindex="0"
                    class="nav-link text-gray-800 text-base font-medium flex items-center gap-2 px-4 py-2 rounded-xl transition-all duration-300 hover:bg-white/20 hover:text-white hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-white/30"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    Categories
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" id="dropdown-arrow">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div
                    id="categoryDropdown"
                    class="absolute left-0 mt-3 w-56 bg-white/95 backdrop-blur-lg border border-white/30 rounded-2xl shadow-2xl opacity-0 invisible transition-all duration-300 transform translate-y-2 z-50"
                    role="menu"
                    aria-labelledby="categoryDropdownBtn"
                >
                    <div class="p-2">
                        @foreach ($categories as $category)
                            <a href="{{ route('category.show', $category->code) }}"
                                class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-gray-900 rounded-xl transition-all duration-200 transform hover:scale-105 group"
                                role="menuitem">
                                <span class="font-medium">{{ ucfirst($category->name) }}</span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-all duration-200 transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="hidden md:block px-6 py-2 text-blue-600 hover:text-blue-800 transition-colors font-medium">
                Login
            </a>
            <a href="{{ route('dataRegister') }}" class="blue-gradient px-6 py-2 text-white rounded-full hover:shadow-lg transition-all duration-300 font-medium animate-pulse-glow">
                Register
            </a>
            <button class="md:hidden">
                <i class='bx bx-menu text-2xl'></i>
            </button>
        </div>

        <!-- Modern Search & Actions -->
        <div class="flex items-center gap-4">
            <!-- Enhanced Search Box -->
            <form action="{{ route('search') }}" method="GET" class="search-box relative group">
                <div class="relative bg-gradient-to-r from-[#e8dedd]/90 to-[#f0e6e5]/90 backdrop-blur-sm rounded-2xl px-4 py-3 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 focus-within:ring-2 focus-within:ring-white/40 focus-within:scale-105">
                    <input type="text" name="query" placeholder="What are you looking for?"
                        class="bg-transparent border-none text-sm placeholder-gray-500 w-48 focus:outline-none font-medium" />
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 p-1 rounded-lg hover:bg-white/30 transition-all duration-200 hover:scale-110">
                        <i class='bx bx-search text-lg text-gray-600 hover:text-gray-800'></i>
                    </button>
                </div>
            </form>

            <!-- Modern Navigation Icons -->
            <div class="nav-icon flex items-center gap-3 text-2xl text-gray-700">
                <!-- Cart with Modern Badge -->
                <a href="{{ route('cart') }}" class="relative p-3 rounded-2xl hover:bg-white/20 transition-all duration-300 transform hover:scale-110 hover:shadow-lg group">
                    <i class='bx bx-cart-alt group-hover:animate-bounce'></i>
                    @if($cartCount > 0)
                        <span id="cart-count" class="absolute -top-1 -right-1 h-6 w-6 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-lg animate-pulse border-2 border-white">
                            {{ $cartCount }}
                        </span>
                    @else
                        <span id="cart-count" class="absolute -top-1 -right-1 h-6 w-6 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-lg border-2 border-white hidden">
                            0
                        </span>
                    @endif
                </a>

                <!-- User Profile -->
                <a href="javascript:void(0);" onclick="toggleDropdown()" class="p-3 rounded-2xl hover:bg-white/20 transition-all duration-300 transform hover:scale-110 hover:shadow-lg group">
                    <i class='bx bx-user group-hover:animate-pulse'></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modern Mobile Menu -->
    <div id="mobileMenu"
        class="mobile-menu overflow-hidden transition-all duration-500 ease-in-out max-h-0 bg-gradient-to-b from-[#b0cee3]/95 to-[#a8c5dc]/95 backdrop-blur-lg border-t border-white/20 md:hidden">
        
        <div class="px-6 py-6 space-y-4">
            <a href="{{ route('home_page') }}" class="block text-gray-800 text-base font-medium py-3 px-4 rounded-xl hover:bg-white/20 hover:text-white transition-all duration-300 transform hover:translate-x-2">
                <i class='bx bx-home mr-3'></i>Home
            </a>
            <a href="{{ route('chat.index') }}" class="block text-gray-800 text-base font-medium py-3 px-4 rounded-xl hover:bg-white/20 hover:text-white transition-all duration-300 transform hover:translate-x-2">
                <i class='bx bx-envelope mr-3'></i>Contact
            </a>

            <!-- Modern Mobile Categories -->
            <details class="group bg-white/10 rounded-xl overflow-hidden backdrop-blur-sm">
                <summary class="cursor-pointer text-gray-800 text-base font-medium list-none flex justify-between items-center py-3 px-4 hover:bg-white/20 hover:text-white transition-all duration-300">
                    <span class="flex items-center">
                        <i class='bx bx-category mr-3'></i>Categories
                    </span>
                    <svg class="w-5 h-5 transition-transform duration-300 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="bg-white/5 border-t border-white/10">
                    @foreach ($categories as $category)
                        <a href="{{ route('category.show', $category->code) }}"
                            class="block py-3 px-8 text-gray-700 hover:text-gray-900 hover:bg-white/10 transition-all duration-200 transform hover:translate-x-2">
                            {{ ucfirst($category->name) }}
                        </a>
                    @endforeach
                </div>
            </details>

            <!-- Mobile Search -->
            <form action="{{ route('search') }}" method="GET" class="search-box relative mt-4">
                <div class="relative bg-gradient-to-r from-[#e8dedd]/90 to-[#f0e6e5]/90 backdrop-blur-sm rounded-2xl px-4 py-3 border border-white/30 shadow-lg">
                    <input type="text" name="query" placeholder="What are you looking for?"
                        class="bg-transparent border-none text-sm placeholder-gray-500 w-full focus:outline-none font-medium" />
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 p-1 rounded-lg hover:bg-white/30 transition-all duration-200">
                        <i class='bx bx-search text-lg text-gray-600'></i>
                    </button>
                </div>
            </form>

            <!-- Mobile Actions -->
            <div class="flex items-center gap-6 text-2xl text-gray-700 mt-6 justify-center">
                <a href="{{ route('cart') }}" class="relative p-3 rounded-2xl hover:bg-white/20 transition-all duration-300 transform hover:scale-110">
                    <i class='bx bx-cart-alt'></i>
                    <span class="absolute -top-1 -right-1 h-6 w-6 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-lg border-2 border-white">2</span>
                </a>
                <a href="javascript:void(0);" onclick="toggleDropdown()" class="p-3 rounded-2xl hover:bg-white/20 transition-all duration-300 transform hover:scale-110">
                    <i class='bx bx-user'></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modern Account Dropdown -->
    <div id="accountDropdown"
        class="account-dropdown absolute right-6 top-20 bg-white/95 backdrop-blur-lg border border-white/30 rounded-2xl w-64 shadow-2xl z-50 hidden overflow-hidden transform transition-all duration-300 translate-y-2 opacity-0">
        
        <div class="p-2">
            <div class="option rounded-xl overflow-hidden transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transform hover:scale-105">
                <a href="{{ route('profile') }}" class="flex items-center gap-4 text-gray-800 text-sm font-medium px-4 py-4 group">
                    <div class="p-2 bg-blue-100 rounded-xl group-hover:bg-blue-200 transition-colors duration-200">
                        <i class='bx bx-user text-blue-600'></i>
                    </div>
                    <span>Manage My Account</span>
                    <i class='bx bx-chevron-right ml-auto text-gray-400 group-hover:text-blue-600 transition-all duration-200 transform group-hover:translate-x-1'></i>
                </a>
            </div>
            
            <div class="option rounded-xl overflow-hidden transition-all duration-200 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transform hover:scale-105">
                <a href="{{ route('order.list') }}" class= "flex items-center gap-4 text-gray-800 text-sm font-medium px-4 py-4 group">
                    <div class="p-2 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors duration-200">
                        <i class='bx bxl-shopify text-green-600'></i>
                    </div>
                    <span>My Order</span>
                    <i class='bx bx-chevron-right ml-auto text-gray-400 group-hover:text-green-600 transition-all duration-200 transform group-hover:translate-x-1'></i>
                </a>
            </div>
            
            <div class="option rounded-xl overflow-hidden transition-all duration-200 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transform hover:scale-105">
                <a href="{{ route('logout') }}" class="flex items-center gap-4 text-red-800 text-sm font-medium px-4 py-4 group">
                    <div class="p-2 bg-red-100 rounded-xl group-hover:bg-red-200 transition-colors duration-200">
                        <i class='bx bx-log-out text-red-600'></i>
                    </div>
                    <span>Logout</span>
                    <i class='bx bx-chevron-right ml-auto text-red-400 group-hover:text-red-600 transition-all duration-200 transform group-hover:translate-x-1'></i>
                </a>
            </div>
        </div>
    </div>
</header>

<style>
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes pulseGlow {
    0% {
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
    }
    100% {
        box-shadow: 0 0 40px rgba(59, 130, 246, 0.8);
    }
}

.blue-gradient {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
}

.animate-pulse-glow {
    animation: pulseGlow 2s ease-in-out infinite alternate;
}

.mobile-menu.active {
    max-height: 500px;
    animation: slideDown 0.3s ease-out;
}
#categoryDropdown.visible {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) !important;
}

#accountDropdown.show {
    opacity: 1 !important;
    transform: translateY(0) !important;
}
.nav-link {
    position: relative;
    overflow: hidden;
}

.nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.nav-link:hover::before {
    left: 100%;
}

/* Cart Badge Pulse */
@keyframes cartPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

#cart-count {
    animation: cartPulse 2s infinite;
}
.backdrop-blur-lg {
    backdrop-filter: blur(16px);
}
* {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

<script>
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById("mobileMenu");
        const hamburgerIcon = document.getElementById("hamburger-icon");
        
        if (mobileMenu.style.maxHeight === "500px") {
            mobileMenu.style.maxHeight = "0";
            hamburgerIcon.className = 'bx bx-menu transition-transform duration-300';
        } else {
            mobileMenu.style.maxHeight = "500px";
            hamburgerIcon.className = 'bx bx-x transition-transform duration-300 rotate-180';
        }
    }
    function toggleDropdown() {
        const dropdown = document.getElementById("accountDropdown");
        
        if (dropdown.classList.contains("hidden")) {
            dropdown.classList.remove("hidden");
            setTimeout(() => {
                dropdown.classList.add("show");
            }, 10);
        } else {
            dropdown.classList.remove("show");
            setTimeout(() => {
                dropdown.classList.add("hidden");
            }, 300);
        }
    }

    // Enhanced Outside Click Handler
    window.addEventListener("click", function (e) {
        const dropdown = document.getElementById("accountDropdown");
        const profileIcons = document.querySelectorAll(".bx-user");

        let isUserIcon = false;
        profileIcons.forEach(icon => {
            if (icon.contains(e.target) || icon.parentElement.contains(e.target)) {
                isUserIcon = true;
            }
        });

        if (!dropdown.contains(e.target) && !isUserIcon) {
            dropdown.classList.remove("show");
            setTimeout(() => {
                dropdown.classList.add("hidden");
            }, 300);
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('categoryDropdownContainer');
        const dropdown = document.getElementById('categoryDropdown');
        const button = document.getElementById('categoryDropdownBtn');
        const arrow = document.getElementById('dropdown-arrow');

        let timeoutId;

        function showDropdown() {
            clearTimeout(timeoutId);
            dropdown.classList.add('visible');
            button.setAttribute('aria-expanded', 'true');
            arrow.style.transform = 'rotate(180deg)';
        }

        function hideDropdown() {
            timeoutId = setTimeout(() => {
                dropdown.classList.remove('visible');
                button.setAttribute('aria-expanded', 'false');
                arrow.style.transform = 'rotate(0deg)';
            }, 150);
        }

        container.addEventListener('mouseenter', showDropdown);
        container.addEventListener('mouseleave', hideDropdown);

        button.addEventListener('focus', showDropdown);
        button.addEventListener('blur', () => {
            setTimeout(() => {
                if (!dropdown.contains(document.activeElement)) {
                    hideDropdown();
                }
            }, 100);
        });

        dropdown.addEventListener('focusin', showDropdown);
        dropdown.addEventListener('focusout', () => {
            setTimeout(() => {
                if (document.activeElement !== button && !dropdown.contains(document.activeElement)) {
                    hideDropdown();
                }
            }, 100);
        });
    });
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 10) {
            header.style.background = 'linear-gradient(to right, rgba(176, 206, 227, 0.98), rgba(168, 197, 220, 0.98))';
            header.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
        } else {
            header.style.background = 'linear-gradient(to right, rgba(176, 206, 227, 0.95), rgba(168, 197, 220, 0.95))';
            header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.05)';
        }
    });
</script>
