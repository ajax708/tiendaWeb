<x-app-layout>
    <div class="p-6">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <p class="text-xl text-gray-700 dark:text-gray-200 mb-6">¡Bienvenido a tu perfil de usuario!</p>

            <div class="mb-8">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Actualizar Información del Perfil</h2>
                    @livewire('profile.update-profile-information-form')
                    <x-section-border />
                @endif
            </div>

            <div class="mb-8">
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Cambiar Contraseña</h2>
                    @livewire('profile.update-password-form')
                    <x-section-border />
                @endif
            </div>

            <div class="mb-8">
                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Autenticación de Dos Factores</h2>
                    @livewire('profile.two-factor-authentication-form')
                    <x-section-border />
                @endif
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Cerrar Sesiones en Otros Navegadores</h2>
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />
                <h2 class="text-lg font-semibold text-red-500 dark:text-red-300">Borrar Cuenta</h2>
                @livewire('profile.delete-user-form')
            @endif
        </div>
    </div>
</x-app-layout>
