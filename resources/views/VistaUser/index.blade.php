@extends('dashboard')

@section('usuario')
    <div class="container mx-auto px-4 my-4">

        <div class="flex flex-col items-center sm:flex-row">
            <div class="mt-4 sm:ml-4">
                <a href="{{ route('user.index') }}"
                    class="bg-indigo-500 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                    Usuarios
                </a>
            </div>
            <div class="mt-4 sm:ml-4">
                <a href="{{ route('rol.index') }}"
                    class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                    Roles
                </a>
            </div>
            <div class="mt-4 sm:ml-4">
                <a href="{{ route('permisos.index') }}"
                    class="bg-orange-500 hover:bg-orange-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                    Permisos
                </a>
            </div>
            <div class="mt-4 sm:ml-4">
                <a href="{{ route('bitacora.index') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">
                    Bitacora
                </a>
            </div>
        </div>


        <div class="my-4 md:my-8 md:mx-8">
            <div class="container mx-auto">
                <div class="overflow-x-auto mx-auto bg-white dark:bg-gray-800 rounded px-2 md:px-8 py-2 md:py-6">
                    <h2 class="text-2xl text-black dark:text-white font-bold mb-6">Lista de Usuarios</h2>
                    <table class="min-w-full bg-white dark:bg-gray-800 text-center">
                        <thead class="bg-indigo-500 text-white">
                            <tr>
                                <th class="py-2 px-4">ID</th>
                                <th class="py-2 px-4">Nombre</th>
                                <th class="py-2 px-4">Email</th>
                                <th class="py-2 px-4">Rol</th>
                                <th class="py-2 px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 text-black dark:text-white">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if ($user->roles->isNotEmpty())
                                            {{ $user->roles->first()->name }}
                                        @else
                                            Sin Rol
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b gap-2 flex justify-center">
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded">
                                            Editar
                                        </a>
                                        <a href="{{ route('user.assign_role', $user->id) }}"
                                            class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
                                            Roles
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
