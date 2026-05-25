<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">Dados Profissionais</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Nome Completo <span class="text-red-500">*</span></label>
            <input type="text" name="nome"
                   value="{{ old('nome', $responsavel->nome ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm @error('nome') border-red-500 @enderror"
                   required />
            @error('nome')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Formação <span class="text-red-500">*</span></label>
            <input type="text" name="formacao"
                   value="{{ old('formacao', $responsavel->formacao ?? '') }}"
                   placeholder="Ex: Engenheiro de Produção"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                   required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Especialização</label>
            <input type="text" name="especializacao"
                   value="{{ old('especializacao', $responsavel->especializacao ?? '') }}"
                   placeholder="Ex: Engenharia de Segurança do Trabalho"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

    </div>
</div>

<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">Registro Profissional</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700">Tipo de Registro <span class="text-red-500">*</span></label>
            <select name="tipo_registro"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm @error('tipo_registro') border-red-500 @enderror"
                    required>
                <option value="">Selecione...</option>
                @foreach($tiposRegistro as $tipo)
                    <option value="{{ $tipo['value'] }}"
                            @selected(old('tipo_registro', $responsavel->tipo_registro->value ?? '') === $tipo['value'])>
                        {{ $tipo['value'] }}
                    </option>
                @endforeach
            </select>
            @error('tipo_registro')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Número do Registro <span class="text-red-500">*</span></label>
            <input type="text" name="numero_registro"
                   value="{{ old('numero_registro', $responsavel->numero_registro ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm font-mono"
                   required />
            @error('numero_registro')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">UF do Registro</label>
            <select name="uf_registro"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                <option value="">Nacional</option>
                @foreach($ufs as $uf)
                    <option value="{{ $uf }}" @selected(old('uf_registro', $responsavel->uf_registro ?? '') === $uf)>
                        {{ $uf }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nº ART / RRT</label>
            <input type="text" name="numero_art_rrt"
                   value="{{ old('numero_art_rrt', $responsavel->numero_art_rrt ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm font-mono" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Data ART / RRT</label>
            <input type="date" name="data_art_rrt"
                   value="{{ old('data_art_rrt', isset($responsavel->data_art_rrt) ? $responsavel->data_art_rrt->format('Y-m-d') : '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

    </div>
</div>

<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">Contato</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" name="email"
                   value="{{ old('email', $responsavel->email ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Telefone</label>
            <input type="text" name="telefone"
                   value="{{ old('telefone', $responsavel->telefone ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

    </div>
</div>
