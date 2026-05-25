# Integração — Especificação 1: Matriz de Risco Inteligente

## 1. Rodar as migrations e o seeder

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=AgentesQuantitativosSeeder
```

## 2. Adicionar as rotas em `routes/web.php`

```php
// Matriz de Risco Inteligente (JSON — sem middleware de role, apenas auth)
Route::middleware('auth')->group(function () {
    Route::get('/agentes/por-risco-tipo/{riscoTipoId}', [AgenteCalculadorController::class, 'porRiscoTipo'])
         ->name('agentes.por-risco-tipo');
    Route::get('/agentes/{agente}/calcular', [AgenteCalculadorController::class, 'calcular'])
         ->name('agentes.calcular');
});
```

Importar no topo do arquivo:
```php
use App\Http\Controllers\AgenteCalculadorController;
```

## 3. Adicionar o JS no `resources/js/app.js`

```js
import './risco-form';
```

Depois rode:
```bash
./vendor/bin/sail npm run dev
# ou, para produção:
./vendor/bin/sail npm run build
```

## 4. Modificar o formulario de Inventário de Riscos

No `create.blade.php` / `edit.blade.php` de `riscos_inventario`,
wrapper principal deve incluir `x-data`:

```html
<form
    method="POST"
    action="{{ route('riscos.store') }}"
    x-data="riscoForm({ riscoTipoId: '{{ old('risco_tipo_id', $risco->risco_tipo_id ?? '') }}', agenteId: '{{ old('agente_quantitativo_id', $risco->agente_quantitativo_id ?? '') }}', valorMedido: '{{ old('valor_medido', $risco->valor_medido ?? '') }}' })"
>
```

No select de `risco_tipo_id`, adicionar o watcher Alpine:
```html
<select name="risco_tipo_id" x-model="riscoTipoId" @change="...">
```

Antes do botão de submit, incluir o componente:
```html
<x-agente-quantitativo-fields />
```

## 5. Modificar RiscosController@store / update

Injetar o service e chamar após salvar o risco:

```php
use App\Services\RiscoCalculadorService;

public function store(RiscoRequest $request, RiscoCalculadorService $calculador)
{
    $risco = RiscoInventario::create($request->validated());

    // Medição quantitativa (opcional)
    if ($request->filled('agente_quantitativo_id') && $request->filled('valor_medido')) {
        $agente    = AgenteQuantitativo::find($request->agente_quantitativo_id);
        $resultado = $calculador->calcular($agente, (float) $request->valor_medido);
        $calculador->aplicarAoRisco($risco, $resultado);
    }

    return redirect()->route('riscos.show', $risco)->with('success', 'Risco cadastrado.');
}
```

Adionar ao `RiscoRequest` (FormRequest):
```php
'agente_quantitativo_id' => 'nullable|exists:agentes_quantitativos,id',
'valor_medido'           => 'nullable|numeric|min:0',
'probabilidade_calculada'=> 'nullable|integer|min:1|max:5',
'severidade_calculada'   => 'nullable|integer|min:1|max:5',
'classificacao_calculada'=> 'nullable|in:baixo,moderado,alto,critico',
```

## 6. Coluna `origem` no PlanoAcao

O model `PlanoAcao` precisa da coluna `origem` no `$fillable`:

```php
protected $fillable = [
    // ... campos existentes ...
    'origem', // 'manual' | 'automatico'
];
```

O cast enum (opcional, Laravel 10+):
```php
protected $casts = [
    'origem' => \App\Enums\PlanoOrigemEnum::class,
];
```

## Fluxo completo após integração

1. Usuário cria risco, seleciona **tipo = Físico**
2. Alpine busca agentes: [Ruído Contínuo, Ruído de Impacto, Calor (IBUTG)]
3. Usuário seleciona **Ruído Contínuo** → aparece input `dB(A)`
4. Usuário digita `86` e tira o foco → fetch para `/agentes/{id}/calcular?valor=86`
5. Card lateral acende em laranja/vermelho:
   - **Nível: ALTO (20)** | P=5 × S=4
   - Limites exibidos: Nível de Ação: 80 dB(A) | Limite de Tolerância: 85 dB(A)
   - Alerta: *"Plano de Ação gerado automaticamente"* com texto da NR-15
6. Usuário submete → controller salva + `RiscoCalculadorService::aplicarAoRisco()` cria `PlanoAcao` com `origem=automatico`
