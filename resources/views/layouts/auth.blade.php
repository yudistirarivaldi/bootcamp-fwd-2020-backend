<!DOCTYPE html>
<html lang="en">

<head>

    @include('include.frontsite.meta')

    <title>@yield('title') | Meet Doctor</title>

    @stack('before-style')

    @include('include.frontsite.style')

    @stack('after-style')



</head>

<body>

    @include('sweetalert::alert')

    @yield('content')

    @include('components.frontsite.footer')

    @stack('before-script')

    @include('include.frontsite.script')

    @stack('after-script')

    {{-- Modals if you have modals you can put this place --}}

</body>

</html>
