<div class="space-y-5">
    <div>
        <x-input-label for="name" value="Nome" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $usuario->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" value="E-mail" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $usuario->email ?? '')" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="empresa_id" value="Empresa" />
        <select id="empresa_id" name="empresa_id" class="mt-1 block w-full rounded-md border-gray-300" required>
            <option value="">Selecione...</option>
            @foreach($empresas as $empresa)
                <option value="{{ $empresa->id }}" @selected(old('empresa_id', $usuario->empresa_id ?? '') == $empresa->id)>
                    {{ $empresa->razao_social }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('empresa_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="role" value="Role" />
        <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300" required>
            @foreach(\App\Enums\UserRole::cases() as $role)
                <option value="{{ $role->value }}" @selected(old('role', $usuario->role?->value ?? '') == $role->value)>
                    {{ ucfirst($role->value) }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="password" value="Senha {{ isset($usuario) ? '(deixe em branco para manter)' : '' }}" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :required="!isset($usuario)" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>
</div>
