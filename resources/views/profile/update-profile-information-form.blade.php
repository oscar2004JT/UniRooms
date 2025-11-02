<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Información del Perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Actualiza la información de tu cuenta y tus datos personales.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Foto de Perfil -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 flex flex-col items-center text-center">
                <!-- Input de Archivo de Foto -->
                <input type="file" id="photo" class="hidden"
                        wire:model.live="photo"
                        x-ref="photo"
                        x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                        " />

                <x-label for="photo" value="{{ __('Foto de Perfil') }}" class="mb-2" />

                <!-- Foto de Perfil Actual -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                         class="rounded-full w-28 h-28 object-cover shadow-md">
                </div>

                <!-- Vista Previa de Nueva Foto -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-28 h-28 bg-cover bg-no-repeat bg-center shadow-md"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="mt-3 flex flex-col sm:flex-row justify-center gap-2">
                    <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Seleccionar Nueva Foto') }}
                    </x-secondary-button>

                    @if ($this->user->profile_photo_path)
                        <x-secondary-button type="button" wire:click="deleteProfilePhoto">
                            {{ __('Eliminar Foto') }}
                        </x-secondary-button>
                    @endif
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Nombre -->
        <div class="col-span-6 sm:col-span-3">
            <x-label for="name" value="{{ __('Nombre') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Apellidos -->
        <div class="col-span-6 sm:col-span-3">
            <x-label for="apellido" value="{{ __('Apellidos') }}" />
            <x-input id="apellido" type="text" class="mt-1 block w-full" wire:model="state.apellido" required autocomplete="family-name" />
            <x-input-error for="apellido" class="mt-2" />
        </div>

        <!-- Cédula -->
        <div class="col-span-6 sm:col-span-3">
            <x-label for="documento" value="{{ __('Documento') }}" />
            <x-input id="documento" type="text" class="mt-1 block w-full" wire:model="state.documento" required autocomplete="off" />
            <x-input-error for="documento" class="mt-2" />
        </div>

        <!-- Teléfono -->
        <div class="col-span-6 sm:col-span-3">
            <x-label for="telefono" value="{{ __('Teléfono') }}" />
            <x-input id="telefono" type="text" class="mt-1 block w-full" wire:model="state.telefono" autocomplete="tel" />
            <x-input-error for="telefono" class="mt-2" />
        </div>

        <!-- Sexo -->
        <div class="col-span-6 sm:col-span-3">
            <x-label for="sexo" value="{{ __('Sexo') }}" />
            <select id="sexo" wire:model="state.sexo"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __('Selecciona una opción') }}</option>
                <option value="M">{{ __('Masculino') }}</option>
                <option value="F">{{ __('Femenino') }}</option>
                <option value="O">{{ __('Otro') }}</option>
            </select>
            <x-input-error for="sexo" class="mt-2" />
        </div>

        <!-- Tipo de Documento -->
        <div class="col-span-6 sm:col-span-3">
            <x-label for="tipo_documento" value="{{ __('Tipo de Documento') }}" />
            <select id="tipo_documento" wire:model="state.tipo_documento"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __('Selecciona una opción') }}</option>
                <option value="CC">{{ __('Cédula de Ciudadanía') }}</option>
                <option value="TI">{{ __('Tarjeta de Identidad') }}</option>
                <option value="CE">{{ __('Cédula de Extranjería') }}</option>
                <option value="PA">{{ __('Pasaporte') }}</option>
                <option value="RC">{{ __('Registro Civil') }}</option>
            </select>
            <x-input-error for="tipo_documento" class="mt-2" />
        </div>

        <!-- Correo Electrónico -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Correo Electrónico') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Tu dirección de correo electrónico no está verificada.') }}
                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        wire:click.prevent="sendEmailVerification">
                        {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button class="bg-blue-700 hover:bg-blue-500 text-white" wire:loading.attr="disabled" wire:target="photo">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>
