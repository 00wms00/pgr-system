{{-- Requer: $empresas, $roles. Opcional: $usuario (para editar) --}}
<div style="display:grid;gap:18px">

    {{-- Nome --}}
    <div>
        <label for="name" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Nome <span style="color:#ef4444">*</span>
        </label>
        <input type="text" id="name" name="name" required maxlength="255"
            value="{{ old('name', $usuario->name ?? '') }}"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('name') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b">
        @error('name')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- E-mail --}}
    <div>
        <label for="email" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            E-mail <span style="color:#ef4444">*</span>
        </label>
        <input type="email" id="email" name="email" required maxlength="255"
            value="{{ old('email', $usuario->email ?? '') }}"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('email') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b">
        @error('email')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Senha --}}
    <div>
        <label for="password" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Senha <span style="color:#ef4444">{{ isset($usuario) ? '' : '*' }}</span>
            @if(isset($usuario))
            <span style="font-size:.72rem;font-weight:400;color:#94a3b8">(deixe em branco para não alterar)</span>
            @endif
        </label>
        <input type="password" id="password" name="password" {{ isset($usuario) ? '' : 'required' }} autocomplete="new-password"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('password') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b">
        @error('password')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Confirmar senha --}}
    <div>
        <label for="password_confirmation"
            style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Confirmar Senha {{ isset($usuario) ? '' : '*' }}
        </label>
        <input type="password" id="password_confirmation" name="password_confirmation"
            {{ isset($usuario) ? '' : 'required' }} autocomplete="new-password"
            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b">
    </div>

    {{-- Perfil --}}
    <div>
        <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:8px">
            Perfil <span style="color:#ef4444">*</span>
        </label>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
            @foreach($roles as $role)
            @php
                $sel = old('role', $usuario->role?->value ?? '') === $role->value;
                $c = match($role->value) {
                    'admin'  => ['bg'=>'#eff6ff','border'=>'#3b82f6','text'=>'#1d4ed8'],
                    'gestor' => ['bg'=>'#f0fdf4','border'=>'#22c55e','text'=>'#15803d'],
                    default  => ['bg'=>'#f8fafc','border'=>'#94a3b8','text'=>'#475569'],
                };
            @endphp
            <label style="display:inline-flex;align-items:center;gap:7px;padding:7px 14px;border-radius:20px;border:2px solid {{ $sel ? $c['border'] : '#e2e8f0' }};background:{{ $sel ? $c['bg'] : '#fff' }};cursor:pointer;font-size:.82rem;font-weight:{{ $sel ? '700' : '500' }};color:{{ $sel ? $c['text'] : '#475569' }}">
                <input type="radio" name="role" value="{{ $role->value }}" @checked($sel) style="display:none">
                {{ $role->label() }}
            </label>
            @endforeach
        </div>
        @error('role')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Empresa --}}
    <div>
        <label for="empresa_id" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Empresa <span style="color:#ef4444">*</span>
        </label>
        <select id="empresa_id" name="empresa_id" required
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('empresa_id') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff">
            <option value="">Selecione a empresa...</option>
            @foreach($empresas as $empresa)
            <option value="{{ $empresa->id }}" @selected(old('empresa_id', $usuario->empresa_id ?? '') == $empresa->id)>
                {{ $empresa->nome_exibicao }} &mdash; {{ $empresa->cnpj }}
            </option>
            @endforeach
        </select>
        @error('empresa_id')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

</div>
