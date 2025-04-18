<x-guest-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Restablecer contraseña') }}</div>

                    <div class="card-body">
                        <x-validation-errors class="mb-4" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Correo Electronico') }}</label>
                                <input id="email" type="email" class="form-control" name="email" :value="old('email')" required autofocus autocomplete="username">
                            </div>
                            <br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">{{ __('Enviar enlace de restablecimiento de contraseña') }}</button>
                            </div>
                        </form>
                        <br>
                        <br>
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <a href="/" class="float-end"> Menu principal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
