<!-- resources/views/email.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
        }

        /* Add more styles as needed */
    </style>
</head>

<body>
    <div class="container">

        <!-- Logo -->
        <img src="{{ url('/assets/img/logo-removebg-preview.png') }}" alt="{{ config('app.name') }} Logo" style="display: block; margin: 0 auto; max-width: 100%;">

        <!-- Header -->
        <header style="background-color: #191970; color: white !important; padding: 10px;">
            <h1 style="margin: 0;">{{ config('app.name') }}</h1>
        </header>

        <!-- Content -->
        <main style="padding: 20px;">
            {{-- Slot for the main content of the email --}}
            {!! nl2br($slot) !!}
        </main>

        <!-- Footer -->
        <footer style="background-color: #191970; color: white; padding: 10px; text-align: center;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </footer>
    </div>
</body>

</html>