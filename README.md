# Projeto Filter

Baseado no vídeo: 
[🔒 FILTRANDO DADOS DE FORMA SEGURA✅ USANDO O ELOQUENT](https://www.youtube.com/watch?v=0ETV1zvsi4A)

## Finalidade

Melhorar os conhecimentos no Eloquent

## Tecnologias

- Laravel
- MariaDB

## Pacotes

| composer require barryvdh/laravel-debugbar --dev

## Problemas

Consulta que deve trazer apenas usuário que não sejam admin

#### 1 Problema
```
    return view('dashboard',[
        'users' => User::query()
            ->where('admin', '=', false)
            ->where('name', 'like', '%'. request()->search .'%')
            ->orWhere('email', 'like', '%'. request()->search .'%')
            ->get()
    ]);
```
#### 1 Delimitando o escopo no Eloquent
```
    return view('dashboard',[
        'users' => User::query()
            ->where('admin', '=', false)
            ->where(function(Builder $q){
                return $q->where('name', 'like', '%'. request()->search .'%')
                        ->orWhere('email', 'like', '%'. request()->search .'%');
            })
            ->get()
    ]);
```

#### 2 Usando o `when`
```
    return view('dashboard',[
        'users' => User::query()
            ->where('admin', '=', false)
            ->when(request()->has('search') && !is_null(request()->get('search')),function(Builder $q){
                return $q->where(function (Builder $q){
                    return $q->where('name', 'like', '%'. request()->search .'%')
                        ->orWhere('email', 'like', '%'. request()->search .'%');
                });
            })
            ->get()
    ]);
```

#### 3 solução com o `filled`
```
    return view('dashboard',[
        'users' => User::query()
            ->where('admin', '=', false)
            ->when(request()->filled('search'),function(Builder $q){
                return $q->where(function (Builder $q){
                    return $q->where('name', 'like', '%'. request()->search .'%')
                        ->orWhere('email', 'like', '%'. request()->search .'%');
                });
            })
            ->get()
    ]);
```

#### 4 Usando `scope`

- Criamos um scope no model User

```
    public function scopeSearch(Builder $q, string $search)
    {
        return $q->where('name', 'like', '%'. $search .'%')
            ->orWhere('email', 'like', '%'. $search .'%');
    }
```

- Código da busca usando scope 
```
    return view('dashboard',[
        'users' => User::query()
            ->where('admin', '=', false)
            ->when(request()->filled('search'),
                fn(Builder $q) => $q->search(request()->search))
            ->get()
    ]);
```

#### 5 Usando `scope` mais simplificado

- Model User
```
    public function scopeSearch(Builder $q, string $search)
    {
        return $q->when(str($search)->isNotEmpty(),
            fn(Builder $q) => $q->where('name', 'like', '%'. $search .'%')
            ->orWhere('email', 'like', '%'. $search .'%'));
    }
```

- Código de busca usando o scope simplificado

```
    return view('dashboard',[
        'users' => User::query()
            ->where('admin', '=', false)
            ->search(request()->search)
            ->get()
    ]);
```

#### 2 Problema
Ordenação dos dados



## Licença
MIT
