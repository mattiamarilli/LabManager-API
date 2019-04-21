LabManager API
==============

## Generic Response

ERROR RESPONSE
```ts
{ error: string, code: number }
```

SUCCESSFUL RESPONSE
```ts
{ message: "OK", code: 200 }
```

# Admin

## Auth

#### POST /admin/auth

BODY
```ts
{ 
    username: string, 
    password: string
}
```
RESPONSE (200)
```ts
{
    id: number,
    nome: string,
    cognome: string,
    admin: boolean
}
```

## Docenti

#### :heavy_check_mark: GET /admin/docente
> Ottiene i docenti

RESPONSE
```ts
[
    {
        id_docente: number,
        nome: string,
        admin: boolean
    },
    ...
]
```

#### :heavy_check_mark: POST /admin/docente
> Crea un docente

BODY
```ts
[
    {
        nome: string,
        admin: boolean
    },
    ...
]
```

#### :heavy_check_mark: PUT /admin/docente
> Modifica un docente

BODY
```ts
[
    {
        id_docente: number,
        nome: string,
        admin: boolean
    },
    ...
]
```

#### :heavy_check_mark: DELETE /admin/docente
> Elimina un docente

BODY
```ts
[
    {
        id_docente: number,
    },
    ...
]
```




## Classi

#### :heavy_check_mark: GET /admin/classe
> Ottiene le classi

RESPONSE
```ts
[
    {
        id_classe: number,
        nome: string,
        anno_scolastico: number,
        enabled: boolean
    },
    ...
]
```

#### :heavy_check_mark: POST /admin/classe/enable
> Abilita una classe

BODY
```ts
{
    id_classe: number,
}
```

#### :heavy_check_mark: DELETE /admin/classe/enable
> Disabilita una classe

BODY
```ts
{
    id_classe: number
}
```

#### :heavy_check_mark: POST /admin/classe
> Aggiunge una classe

BODY
```ts
[
    {
        nome: string,
        anno_scolastico: number
    },
    ...
]
```

## Gruppi

#### GET /admin/gruppo
> Ottiene i gruppi correnti

RESPONSE
```ts
[
    {
        id_gruppo: number,
        studenti: [
            {
                id_studente: number,
                nome: string,
                cognome: string,
                id_classe: number,
                classe: string
            },
            ...
        ]
    },
    ...
]
```

## Studenti

#### :heavy_check_mark: GET /admin/studente
> Ottiene gli studenti

RESPONSE
```ts
[
    {
        id: number, 
        nome: string, 
        cognome: string, 
        id_classe: number, 
        classe: string, 
        id_gruppo: number,
        username: string
    },
    ...
]
```

#### :heavy_check_mark: POST /admin/studente
> Aggiunge uno studente

BODY
```ts
{
    nome: string,
    cognome: string,
    id_classe: number
}
```

#### :heavy_check_mark: PUT /admin/studente
> Modifica uno studente

BODY
```ts
{
    nome: string,
    cognome: string,
    id_classe: number
    id_studente: number
}
```

#### :heavy_check_mark: DELETE /admin/studente
> Elimina uno studente

BODY
```ts
{
    id_studente: number
}
```

## Utensili

#### :heavy_check_mark: GET /admin/utensile
> Ottiene gli utensili

RESPONSE
```ts
[
    {
        id_utensile: number,
        nome: string,
        segnala: boolean,
        id_categoria: number,
        categoria: string
    },
    ...
]
```

#### :heavy_check_mark: POST /admin/utensile
> Aggiunge un utensile

BODY
```ts
{
    nome: string,
    segnala: boolean,
    id_categoria: number
}
```

#### :heavy_check_mark: DELETE /admin/utensile
> Aggiunge un utensile

BODY
```ts
{
    id: number
}
```

#### :heavy_check_mark: DELETE /admin/utensile/segnalazione
> Aggiunge un utensile

BODY
```ts
{
    id: number
}
```

#### :heavy_check_mark: GET /admin/categoria
> Ottiene le categorie

RESPONSE
```ts
[
    {
        id_categoria: number,
        nome: string
    },
    ...
]
```

#### :heavy_check_mark: POST /admin/categoria
> Aggiunge una categoria

RESPONSE
```ts
{
    nome: string
}
```

# Studenti

## Auth

#### POST /user/auth
BODY
```ts
{ 
    username: string, 
    password: string
}
```
RESPONSE (200)
```ts
{
    id: number,
    nome: string,
    cognome: string,
    id_classe: number,
    classe: number,
    id_gruppo: number
}
```

## Gruppi

#### POST /user/gruppo
> Entra nel gruppo con studente *id_studente*

BODY
```ts
{
    id_studente: number
}
```

#### :heavy_check_mark: DELETE /user/gruppo
> Lascia il gruppo

BODY
```ts
{
    id_studente: number
}
```

#### GET /user/gruppo
> Ottiene i compagni nel gruppo

RESPONSE
```ts
[
    {
        id: number,
        nome: string,
        cognome: string
    },
    ...
]
```

## Compagni di classe

#### GET /user/compagno
> Ottiene i compagni di classe

RESPONSE
```ts
[
    {
        id: number,
        nome: string,
        cognome: string
    },
    ...
]
```

#### POST /user/utensile
> Utilizza un utensile

BODY
```ts
{
    id: number
}
```

#### POST /user/categoria
> Utilizza un utensile data una categoria

BODY
```ts
{
    id: number
}
```

#### GET /user/utensile
> Ottiene gli utensili in uso

RESPONSE
```ts
[
    {
        id_utensile: number,
        nome: string,
        segnala: boolean,
        id_categoria: number,
        categoria: string
    },
    ...
]
```

#### DELETE /user/utensile
> Restituisce utensile

BODY
```ts
{
    id: number,
    segnala: boolean
}
```
