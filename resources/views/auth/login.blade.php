<x-guest-layout>
    <style>
        .body {
            background: #000000;
        }
    </style>
    <!-- Comienzo del login-->
    <div class="min-h-screen flex items-center justify-center custom-bg bg-gray-100 dark:bg-gray-900">
        <div class="w-1/2 lg:flex lg:items-stretch bg-blue-500 dark:bg-sky-950 rounded-xl items-center justify-center">

            <div class="lg:w-3/5 md:w-1/2 bg-cover bg-center lg:rounded-l-lg"
                style="background-image: url('{{ asset('img/portadatienda.png') }}')">
            </div>

            <div class="lg:w- bg-white dark:bg-gray-800 p-10 lg:rounded-r-lg md:ml-auto">
                <img class="mx-auto  items-center justify-center" src="{{ asset('img/logo.png') }}" width="102" alt="">
                <h2 class="font-semibold text-center text-2xl py-3">Bienvenido!!</h2>
                <!--Verificación de la validación de inicio de sesión-->
                <x-validation-errors class="mb-2" />
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <!--LOGIN-->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4"> <!--Email-->
                        <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2"
                            for="email">{{ __('Correo Electrónico') }}</label>
                        <input id="email" type="email"
                            class="text-gray-600 w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="text-red-500 text-sm mt-1" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4"> <!-- Contraseña-->
                        <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2"
                            for="password">{{ __('Contraseña') }}</label>
                        <input id="password" type="password"
                            class="text-gray-600 w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <!-- Comprueba la contraseña-->
                            <span class="text-red-500 text-sm mt-1" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4"><!-- Contraseña olvidada-->
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-gray-600 dark:text-white">¿Has olvidado la
                                contraseña?</a>
                        @endif
                    </div>

                    <div class="mb-4 flex items-center">
                        <input class="mr-2 leading-tight" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="text-sm text-gray-700 dark:text-white" for="remember">{{ __('Recuérdame') }}</label>
                    </div>

                    <div class="mb-4">
                        <button type="submit"
                            class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg focus:outline-none focus:shadow-outline-blue focus:border-blue-700">
                            {{ __('Iniciar Sesión') }}
                        </button>
                    </div>

                    <div class="my-3 text-center">
                        <span class="text-gray-600 dark:text-white">¿No tienes una cuenta? <a href="{{ route('register') }}"
                                class="text-blue-500">Regístrate</a></span>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <a href="/" class="text-blue-500">Menú principal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
