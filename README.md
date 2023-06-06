# Projeto Filter

Baseado no vídeo: 
[🔒 FILTRANDO DADOS DE FORMA SEGURA✅ USANDO O ELOQUENT](https://www.youtube.com/watch?v=0ETV1zvsi4A)

## Finalidade

Melhorar os conhecimentos no Eloquent

## Pacotes

| composer require barryvdh/laravel-debugbar --dev

## Problemas

Consulta que deve trazer apenas usuário que não sejam admin

1º Problema
```
    return view('dashboard',[
        'users' => User::query()
            ->where('admin', '=', false)
            ->where('name', 'like', '%'. request()->search .'%')
            ->orWhere('email', 'like', '%'. request()->search .'%')
            ->get()
    ]);
```
Solução
Delimitando o escopo no Eloquent
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
Melhorando a solução
Usando o `when`
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

Outra solução com o `filled`
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

## Tecnologias

- Laravel
- MariaDB

## Licença
MIT
