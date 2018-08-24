# By upper

Es un micro template para trabajar con wordpress, posee un esqueleto similar al que ofrece [Pine](https://github.com/azeemhassni/pine)


## Directorio

El esqueleto básico backend es minimalista.

```
by-upper
├───assets
|   ├───style
|   └───index.js
├───script
|   └───custom-twig.php
├───static
└───views
  ├───includes
  |   ├───footer.twig
  |   └───header.twig
  ├───layouts
  |   └───master.twig
  └───pages
      ├───index.twig
      └───404.twig
```

## Utilidades frontend

### Rollup

ya viene preconfigurado para trabajar con rollup, dando soporte por defecto sobre las siguientes tecnologías:

- [node-resolve](https://github.com/rollup/rollup-plugin-node-resolve) : permite importar modulos desde node_modules, hacia el bundle js final.
- [postcss](https://postcss.org/) : permite extender fasilmente el codigo css.
  - [postcss-preset-env](https://preset-env.cssdb.org/) : añade soporte para funcionalidades actuales dentro del css.
  - [css-mqpacker](https://github.com/hail2u/node-css-mqpacker) : permite reducir el tamaño del css agrupando reglas de media.
  - [merge-rules](https://github.com/ben-eb/postcss-merge-rules) : permite reducir el tamaño del css agrupando reglas de selectores.
  - [cssnano](http://cssnano.co/) : comprime el codigo css.
- [buble](https://buble.surge.sh/guide/) : permite escribir es6 moderno.


## Funciones especiales

| Funcion | argumentos | descripción |
|:--------|:-----------|:------------|
| getField | ... | proxy de `get_field` |
| getOptions |  | obtiene de acf los fields de las paginas de opción |
| getMenu | ... | proxy de `Timbet\Menu` |
| getPosts | ... | proxy de `Timber\Timber::get_posts` |
| getTerm | ... | proxy de `Timber\Term` |
| getTerms | ... | proxy de `Timber\Timber::get_terms` |
| getPost | ... | proxy de `Timber\Post` |
| getClassBody | ...$appendClassName | permite añadir u optener las clases asociadas al a página |
| setStyleInline | object | permite generar el atributo `style` con css inline |
| setAttrs | object | permite imprimir atributos desde un objeto |

## Filtros especiales

|Filtro | descripción |
|:------|:------------|
| normalize | limpia el html limitando su uso a cierto tipos de caracteres `<strong><a><br>` |