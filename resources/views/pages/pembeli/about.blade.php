@extends('layouts.app')

@section('content')

<body class="font-sans bg-white">
  <div class="about-page relative" x-data="{ open: false, team: null }">

    <!-- Breadcrumb -->
    <div class="max-w-4xl mx-auto px-10 flex flex-row items-center gap-3 mt-10">
      <a href="{{ route('home_page') }}" class="text-black hover:underline opacity-50">Home</a>
      <div class="h-4 border-l border-gray-500 opacity-70 transform rotate-45"></div>
      <span class="text-black font-semibold">About Company</span>
    </div>

    <!-- Company Introduction -->
<div class="flex flex-col md:flex-row items-center justify-between px-10 py-14 max-w-6xl mx-auto bg-white rounded-xl shadow-md">
  <div class="text-justify max-w-2xl mb-8 md:mb-0">
    <h1 class="text-4xl font-bold mb-6 text-gray-800">About E-TechnoCart</h1>
    <p class="text-gray-700 text-justify leading-relaxed mb-5">
      E-TechnoCart is a technology company engaged in the sale and distribution of modern electronic products. We provide a wide range of products from televisions, laptops, smartphones, smart home devices, to high-quality electronic accessories.
    </p>
    <p class="text-gray-700 text-justify leading-relaxed mb-5">
      With a focus on customer convenience and trust, E-TechnoCart aims to deliver a safe, fast, and reliable online electronics shopping experience.
    </p>
    <p class="text-gray-700 text-justify leading-relaxed">
      We are committed to continuously innovating and becoming the best technology partner for all Indonesians.
    </p>
  </div>
  <div class="ml-0 md:ml-10 w-full max-w-md">
    <img src="{{ asset('image/POLIBATAM.jpg') }}" alt="Electronics Company"
         class="rounded-xl shadow-lg w-full object-cover transition duration-300 hover:scale-105 hover:shadow-2xl" />
  </div>
</div>


    <!-- Vision & Mission -->
    <div class="bg-gray-100 py-10 mt-6">
      <div class="max-w-6xl mx-auto px-8 text-justify">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Vision</h2>
            <p class="text-gray-600 leading-relaxed">
              To become Indonesia's leading, innovative, and trustworthy e-commerce platform focused on customer satisfaction.
            </p>
          </div>
          <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Mission</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-2 text-justify">
              <li>Provide high-quality electronic products with official warranties.</li>
              <li>Deliver an easy and secure online shopping experience.</li>
              <li>Offer responsive and solution-oriented customer service.</li>
              <li>Continuously innovate in line with technological advancements.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Company Values -->
    <div class="py-10 px-8 max-w-6xl mx-auto text-justify">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Our Values</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="text-lg font-semibold mb-2 text-gray-800">Trust</h3>
          <p class="text-gray-600">We uphold integrity and transparency in every transaction.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="text-lg font-semibold mb-2 text-gray-800">Innovation</h3>
          <p class="text-gray-600">We constantly develop our services and products with the latest technologies.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="text-lg font-semibold mb-2 text-gray-800">Customer Satisfaction</h3>
          <p class="text-gray-600">We are committed to providing the best and most responsive service.</p>
        </div>
      </div>
    </div>

    <!-- Team Development -->
    <div class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-4 text-gray-800">Team Development</h2>
        <p class="text-gray-600 mb-10">Meet the people behind E-TechnoCart</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          @php
            $teams = [
              ['name' => 'Steven Marcell S', 'role' => 'Project Leader & Fullstack Dev', 'img' => 'tepenbg.png'],
              ['name' => 'Aisyah Nurwa Hida', 'role' => 'Frontend & Buyer Features', 'img' => 'ais2.png'],
              ['name' => 'Naylah Amirah A', 'role' => 'Frontend & Checkout System', 'img' => 'naylah3.png'],
              ['name' => 'Fahmi Ahmad F', 'role' => 'Backend & Admin Features', 'img' => 'Fahmibg.png'],
            ];
          @endphp
          @foreach($teams as $member)
          <div @click="open = true; team = {{ json_encode($member) }}"
            class="cursor-pointer bg-white rounded-xl shadow hover:shadow-lg transition p-4 text-center">
            <img src="{{ asset('image/' . $member['img']) }}" alt="{{ $member['name'] }}"
              class="w-24 h-24 mx-auto rounded-full object-cover mb-4 ring-4 ring-blue-100" />
            <h3 class="font-semibold text-lg text-gray-800">{{ $member['name'] }}</h3>
            <p class="text-sm text-blue-600">{{ $member['role'] }}</p>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Modal -->
      <div x-show="open" x-transition @click.away="open = false"
        class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-white text-gray-900 rounded-xl shadow-xl p-8 max-w-md w-full relative max-h-[90vh] overflow-y-auto">
          <button @click="open = false"
            class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
          <template x-if="team">
            <div class="flex flex-col items-center space-y-4 px-2">
              <img :src="'/image/' + team.img"
                class="w-32 h-32 rounded-full object-cover object-top shadow-md ring-4 ring-blue-100 transition duration-300" />
              <h3 class="text-2xl font-bold text-center" x-text="team.name"></h3>
              <p class="text-blue-600 text-sm font-medium text-center" x-text="team.role"></p>
              <p class="text-sm text-gray-700 text-justify leading-relaxed px-1" x-text="getTeamDescription(team.name)"></p>
            </div>
          </template>
        </div>
      </div>

      <script>
        function getTeamDescription(name) {
          switch (name) {
            case 'Steven Marcell S':
              return 'Project leader responsible for the full stack, Git management, UI/UX, and deployment.';
            case 'Aisyah Nurwa Hida':
              return 'Handles both frontend and backend, focusing on buyer features from browsing to checkout. Contributed to UI/UX and deployment.';
            case 'Naylah Amirah A':
              return 'In charge of frontend/backend related to checkout, transaction validation, and payment form logic. Contributed to UI/UX and deployment.';
            case 'Fahmi Ahmad F':
              return 'Developed admin features and buyer-seller messaging system, contributed to backend and UI/UX.';
            default:
              return '';
          }
        }
        document.addEventListener('alpine:init', () => {
          Alpine.data('aboutPage', () => ({
            open: false,
            team: null,
            getTeamDescription
          }))
        });
      </script>
    </div>
  </div>
</body>
@endsection
