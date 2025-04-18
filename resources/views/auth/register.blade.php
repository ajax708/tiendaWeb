<x-guest-layout>
    <style>
        .custom-bg {
            background-image: url('{{ asset("images/background.jpg") }}');
            background-size: cover;
        }
    </style>

    <!-- Comienzo del registro -->
    <div class="min-h-screen flex items-center justify-center custom-bg bg-gray-100">
        <div class="bg-white w-4/5 md:w-1/2 lg:w-2/5 xl:max-w-md p-6 rounded-lg shadow-lg">
            <div class="text-center">
                <img src="{{ asset('images/logo-prueba.jpg') }}" width="48" alt="">
                <h1 class="text-2xl font-bold py-3">Registro</h1>
            </div>

            <!-- Verificación de la validación del registro -->
            <x-validation-errors class="mb-2" />

            <!-- Registro -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <!-- Nombre -->
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">{{ __('Nombre Completo') }}</label>
                    <input id="name" type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <!-- Correo Electrónico -->
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required>
                    @error('email')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <!-- Contraseña -->
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror" name="password" required>
                    @error('password')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <!-- Confirmación de Contraseña -->
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">{{ __('Confirmar Contraseña') }}</label>
                    <input id="password_confirmation" type="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" name="password_confirmation" required>
                </div>

                <div class="mb-4">
                    <button type="submit" class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg focus:outline-none focus:shadow-outline-blue focus:border-blue-700">
                        {{ __('Registrarse') }}
                    </button>
                </div>

                <div class="my-3 text-center">
                    <span>¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-blue-500">Inicia Sesión</a></span>
                </div>

                <div class="text-right">
                    <a href="/" class="text-gray-500"> Menú principal</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
