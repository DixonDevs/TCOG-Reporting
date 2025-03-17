<header class="sticky-header-wrapper">
    <div class="sticky-header">
        <img class="daniel-image" src="/images/8bit-image-of-Daniel.jpg" alt="8-bit Character of Daniel Dixon">
        <h1 class="name-logo">TCOG Reporting</h1>
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
</header>