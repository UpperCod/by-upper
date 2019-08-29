# wordpres-base

Es un template para wordpress, pensado para un diseño desde 0, entrega un espacio de trabajo cómodo y orientado a un desarrollo escalable gracias al uso de Twig para manejar plantillas mediante el plugin Timber y un espacio frontend amigable.

## frontend

```json
{
	"scripts": {
		"build": "bundle src/*.js,src/css/*.css static/dist",
		"dev": "bundle src/*.js,src/css/*.css static/dist -w"
	}
}
```

ud solo necesita arrancar 2 tareas para su desarrollo, la exportación es moderna a base de módulos es6, el soporte para navegadores `default last 2 versions)`, checar [browserlist](https://github.com/browserslist/browserslist), para definir otro prefijo mediante el uso del flag `--browsers`, este ajustara bable y postcss.

**El css se importan inline en el documento**.

## backend

## variables de configuración

la dependencias generadas por bundle, pueden ser declarados mediante las siguientes constantes.

```twig
{% set page_scripts = ["index.js"] %}
{% set page_styles = ["index.css"] %}
```

## creacion de formularios

ud puede crear formularios de forma simple mediante el uso de la función `createForm`, este permite generar un token con data inmutable para luego comprobar entre sesiones, el token solo se destruye una vez validado el form, eg:

```twig
<form {{ createForm({
	subject : "Mensaje desde el sitio",
	to : form.to,
	back : page.link
}) }}>
	<input required name="form:Nombre" placeholder="{{form.inputName|default("Nombre")}}"/>
	<input required name="form:Telefono" placeholder="{{form.inputTel|default("Telefono")}}"/>
	<input type="email" required name="form:Email" placeholder="{{form.inputEmail|default("Email")}}"/>
	<input required name="form:Desde" type="hidden" value="{{page.link}}"/>
	<textarea required name="form:Mensaje" placeholder="{{form.inputMessage|default("Mensaje")}}" rows="1"></textarea>
	<button>Enviar mensaje</button>
</form>
```

## funciones especiales

algunas funciones propias de Timber fueron incluidas como funciones de twig, para facilitar la construcción de témplate sin la necesidad de invocar php.

### getPost(WpQuery) y getPosts(WpQuery)

### getMenu(Query)

### getTerm(Query) y getTerms(Query)

### getOptions()

### getField()

### client

permite saber el tipo dispositivo y navegador usado por el cliente

```twig
client("chrome")
```

### createForm
