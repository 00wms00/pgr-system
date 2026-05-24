<div class="space-y-5">
    <div>
        <x-input-label for="razao_social" value="Razão Social" />
        <x-text-input id="razao_social" name="razao_social" type="text" class="mt-1 block w-full" :value="old('razao_social', $empresa->razao_social ?? '')" required />
        <x-input-error :messages="$errors->get('razao_social')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="nome_fantasia" value="Nome Fantasia" />
        <x-text-input id="nome_fantasia" name="nome_fantasia" type="text" class="mt-1 block w-full" :value="old('nome_fantasia', $empresa->nome_fantasia ?? '')" />
        <x-input-error :messages="$errors->get('nome_fantasia')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="cnpj" value="CNPJ" />
        <x-text-input id="cnpj" name="cnpj" type="text" class="mt-1 block w-full font-mono" placeholder="00.000.000/0001-00" :value="old('cnpj', $empresa->cnpj ?? '')" required />
        <x-input-error :messages="$errors->get('cnpj')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="endereco" value="Endereço" />
        <x-text-input id="endereco" name="endereco" type="text" class="mt-1 block w-full" :value="old('endereco', $empresa->endereco ?? '')" />
        <x-input-error :messages="$errors->get('endereco')" class="mt-2" />
    </div>
    <div class="flex items-center gap-3">
        <input type="hidden" name="ativo" value="0">
        <input type="checkbox" id="ativo" name="ativo" value="1" class="rounded border-gray-300" {{ old('ativo', $empresa->ativo ?? true) ? 'checked' : '' }}>
        <x-input-label for="ativo" value="Empresa ativa" />
    </div>
</div>
