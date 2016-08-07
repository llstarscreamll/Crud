# CRUD Generator #

CrudGenerator es un paquete de laravel para la generación de aplicaciones CRUD básicas a partir de una tabla de una base de datos, sevirá como un buen punto de partida para el gestor de una entidad o tabla en la base de datos.

## Instalación ##

Clonar el repositorio donde se desee:

```bash
git clone git@github.com:llstarscreamll/CrudGenerator.git packages/llstarscreamll/CrudGenerator
```

Cargar através de composer:

```json
"autoload": {
        "psr-4": {
            "App\\": "app/",
            "llstarscreamll\\CrudGenerator\\": "packages/llstarscreamll/CrudGenerator/src"
        }
    }
```

Añadir el service provider en `config/app.php`:

```php
'providers' => [
        llstarscreamll\CrudGenerator\Providers\CrudGeneratorServiceProvider::class,
    ],
```

Publicar configuraciones, vistas, etc..

```bash
php artisan publish --vendor=llstarscreamll\CrudGenerator\Providers\CrudGeneratorServiceProvider
```

Presta mucha atención a los archivos de configuración publicados en la carpeta `config/llstarscreamll/CrudGenerator`, da valores a las variables que allí hay acorde a las necesidades.

## Clases/Archivos Generados: ##

### Modelos Eloquent ###

Crea los modelos para la CRUD app con los atributos `$table`, `$primaryKey`, `$timestamps`, `$hidden`, `$guard`, `$fillable`, `$dates` y la propiedad para fijar que conexión usar para el modelo  `$connection` comentada; también añade la clase `SoftDeletes` si se detecta la columna `deleted_at` en la tabla especificada, pero para el caso de los `timestamps` el paquete los usa por defecto. Las relaciones con otros modelos también son configuradas según como se indique en el formulario de creación de la CRUD app, actualmente las relaciones soportadas son `belongsTo`, `hasOne`, `hasMany` y `belongsToMany`.

Las cláusulas de las consultas del formulario búsqueda se hacen en el método `findRequested($request)`, allí se define en qué columnas buscar y ordenar, la páginación se cada 15 registros (aún no hay opción para cambiar paginación). Para los campos de fecha se busca por rangos de fecha, y si se hace uso de la clase `SoftDeletes` añade cláusula para consultar **con los elementos "en papelera"** o **sólo los "elementos en papelera"** según indique el usuario.

Las reglas de validación son dadas en el método `validationRules($attributes = null, $request, $route = null)` pues no se ha hecho uso de los FormRequest de Laravel, si no que las validaciones de hacen en los controladores. Las reglas de validación pueden cambiar a conveniencia según la ruta en la que se encuentre, simplemente pasando el respectivo valor en el parámetro `$route`.

Aquí un ejemplo sencillo de un Modelo generado de una entidad Producto:

```php
<?php

namespace grapas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * El nombre de la conexión a la base de datos del modelo.
     *
     * @var string
     */
    //protected $connection = 'connection-name';

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * La llave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Los atributos que SI son asignables.
     *
     * @var array
     */
    protected $fillable = [
        'internal_code',
        'name',
        'description',
    ];

    /**
     * Los atributos que NO son asignables.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * Los atributos ocultos al usuario.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Indica si Eloquent debe gestionar los timestamps del modelo.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Los atributos que deben ser convertidos a fechas.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * El formato de almacenamiento de las columnas de tipo fecha del modelo.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Devuelve un "nombre personalizado" del modelo.
     * 
     * @return string
     */
    public function getCustomNameAttribute()
    {
        return $this->name;
    }

    /**
     * Realiza la consulta de los datos del modelo según lo que el usuario especifique.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public static function findRequested($request)
    {
        $query = self::query();

        // buscamos basados en los datos que señale el usuario
        $request->get('id') and $query->where('id', $request->get('id'));

        $request->get('internal_code') and $query->where('internal_code', 'like', '%'.$request->get('internal_code').'%');

        $request->get('name') and $query->where('name', 'like', '%'.$request->get('name').'%');

        $request->get('description') and $query->where('description', 'like', '%'.$request->get('description').'%');

        $request->get('created_at')['informative'] and $query->whereBetween(
            'created_at',
            [
            $request->get('created_at')['from'],
            $request->get('created_at')['to'],
            ]
        );

        $request->get('updated_at')['informative'] and $query->whereBetween(
            'updated_at',
            [
            $request->get('updated_at')['from'],
            $request->get('updated_at')['to'],
            ]
        );

        $request->get('deleted_at')['informative'] and $query->whereBetween(
            'deleted_at',
            [
            $request->get('deleted_at')['from'],
            $request->get('deleted_at')['to'],
            ]
        );

        // registros en papelera
        $request->has('trashed_records') and $query->{$request->get('trashed_records')}();
        // ordenamos los resultados
        $request->get('sort') and $query->orderBy($request->get('sort'), $request->get('sortType', 'asc'));

        // paginamos los resultados
        return $query->paginate(15);
    }

    /**
     * Las reglas de validación para el modelo.
     *
     * @param string|array             $attributes Las reglas de los atributos que se quiere devolver
     * @param \Illuminate\Http\Request $request
     * @param string                   $route      La ruta desde donde se quiere obtener las reglas
     *
     * @return array
     */
    public static function validationRules($attributes = null, $request, $route = null)
    {
        $rules = [
        'id' => '',
        'internal_code' => 'required|text',
        'name' => 'required|text',
        'description' => 'required|text',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
        ];

        // hacemos los cambios necesarios a las reglas cuando la ruta sea update
        if ($route == 'update') {
        }

        // no se dieron atributos
        if (!$attributes) {
            return $rules;
        }

        // se dio un atributo nada mas
        if (!is_array($attributes)) {
            return [$attributes => $rules[$attributes]];
        }

        // se dio una lista de atributos
        $newRules = [];
        foreach ($attributes as $attr) {
            $newRules[$attr] = $rules[$attr];
        }

        return $newRules;
    }
}

```

### Controladores ###

Los controladores tienen en el constructor los middlewares de acceso al recurso, comprobando que el usuario esté logeado y que tenga los permisos necesarios para acceder a la ruta que indicada, los middleware son `auth` y 
`checkPermissions`, si no se cuenta con un sistema ACL puede borrar la línea del segundo middleware. El controlador tiene los métodos comunes, pero si se ha detectado que la entidad tiene la columna `deleted_at`, entonces será añadido otro método para restablecer los registros que estén "en la papelera". Aquí un ejemplo de un controlador generado para una entidad Producto:

```php
<?php

namespace grapas\Http\Controllers;

use grapas\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * El directorio donde están las vistas.
     *
     * @var string
     */
    public $viewDir = 'products';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // el usuario debe estar autenticado para acceder al controlador
        $this->middleware('auth');
        // el usuario debe tener permisos para acceder al controlador
        $this->middleware('checkPermissions');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // los datos para la vista
        $data = array();

        $data['records'] = Product::findRequested($request);

        return $this->view('index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // los datos para la vista
        $data = array();

        return $this->view('create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Product::validationRules(null, $request), [], trans('product/validation.attributes'));

        Product::create($request->all());
        $request->session()->flash('success', trans('product/messages.create_product_success'));

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // los datos para la vista
        $data = array();
        $data['product'] = Product::findOrFail($id);

        return $this->view('show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // los datos para la vista
        $data = array();
        $data['product'] = Product::findOrFail($id);

        return $this->view('edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->isXmlHttpRequest()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, Product::validationRules($request->name, $request), [], trans('product/validation.attributes'));

            if ($validator->fails()) {
                return response($validator->errors()->first($request->name), 403);
            }

            $product->update($data);

            return 'Record updated';
        }

        $this->validate($request, Product::validationRules(null, $request, 'update'), [], trans('product/validation.attributes'));

        $product->update($request->all());
        $request->session()->flash('success', trans('product/messages.update_product_success'));

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        Product::destroy($id) ? $request->session()->flash('success', trans_choice('product/messages.destroy_product_success', count($id))) : $request->session()->flash('error', trans_choice('product/messages.destroy_product_error', count($id)));

        return redirect()->route('products.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        Product::onlyTrashed()->whereIn('id', $id)->restore() ? $request->session()->flash('success', trans_choice('product/messages.restore_product_success', count($id))) : $request->session()->flash('error', trans_choice('product/messages.restore_product_error', count($id)));

        return redirect()->route('products.index');
    }

    /**
     * Devuelve la vista con los respectivos datos.
     *
     * @param string $view
     * @param string $data
     *
     * @return \Illuminate\Http\Response
     */
    protected function view($view, $data = [])
    {
        return view($this->viewDir.'.'.$view, $data);
    }
}
```

### Model Binding y Rutas ###

El paquete genera el **Model Binding** para cada recurso (sólo si no se hace uso de `SoftDeletes`), en el archivo `app/Providers/RouteServiceProvider.php` de la siguiente forma:

```php
public function boot(Router $router)
    {
        $router->model('preferences', 'grapas\Models\Preference');

        parent::boot($router);
    }
```

Para el Model Binding no pudimos seguir el ejemplo de la entidad Producto pues si hacía uso de `SoftDeletes`.

La ruta generada para el recurso queda de la siguiente forma, siguiendo el ejemplo de la entidad Producto, esta vez con una ruta de mas para restaurar los registros que están "en la papelera":

```php
Route::put(
    '/machines/restore/{machines}',
    [
    'as' => 'machines.restore',
    'uses' => 'MachineController@restore',
    ]
);

Route::resource('products', 'ProductController');
```


### Archivos de Idioma ###

El paquete genera los strings de idioma para la CRUD app, el idioma generado por defecto es el español y parte de lo que se le indique en el formulario de creación de la app. Se genera una carpeta que para el ejemplo de la entidad Productos tendrá el nombre `product`; para el nombre de las carpetas se usa el nombre de la entidad o **tabla en la base de datos**, en **singular** y en **cameCase**, dentro se generan 3 ficheros:

- **messages.php:** que contienen los mensajes o notificaciones enviadas desde los controladores al usuario.
- **validation.php:** que contiene los nombres de los atributos de la entidad para los formularios de creación/edición de registros, y si se desea, un buen lugar para dejar los mensajes de error de validación de dichos formularios.
- **views.php:** que contiene los demás strings usados en la interfaz de usuario, como los nombres de las cabeceras, de botones, textos de ayuda, nombres cortos de los atributos de la entidad para la tabla del index donde son listados los registros, etc.

Siguiendo con el ejemplo de la entidad Producto, aquí los archivos de idioma generados:

`resources/lang/es/product/messages.php`
```php
<?php

return [

    /*
     * Los mensajes de notificación cuando el usuario hace algún tipo de
     * transacción en el sistema, como crear/editar/borrar un registro.
     */

    // mesajes del método store() del controlador
    'create_product_success' => 'Producto creado correctamente.',
    'create_product_error' => 'Ocurrió un error creando el producto.',

    // mesajes del método update() del controlador
    'update_product_success' => 'Producto actualizado correctamente.',
    'update_product_error' => 'Ocurrió un error actualizando el producto.',

    // mesajes del método destroy() del controlador
    'destroy_product_success' => 'El producto ha sido movido a la papelera.|Los productos han sido movidos a la papelera correctamente.',
    'destroy_product_error' => 'Ocurrió un problema moviendo el producto a la papelera.|Ocurrió un error moviendo los productos a la papelera.',

    // mesajes del método restore() del controlador
    'restore_product_success' => 'El producto ha sido restaurado correctamente.|Los productos han sido restaurados correctamente.',
    'restore_product_error' => 'Ocurrió un problema restaurando el producto.|Ocurrió un error restaurando los productos.',

];
```

`resources/lang/es/product/validation.php`
```php
<?php

return [
    /*
     * Los campos y/o mensajes de validación del formulario del módulo.
     */

    /*
     * Los atributos del modelo.
     */
    'attributes' => [
        'id' => 'El id',
        'internal_code' => 'El código interno',
        'name' => 'El nombre',
        'description' => 'La descripción',
        'created_at' => 'La fecha de creación',
        'updated_at' => 'La fecha de actualización',
        'deleted_at' => 'La fecha de eliminación',
    ],
];
```

`resources/lang/es/product/views.php`
```php
<?php

return [

    /*
     * Los textos de las vistas como por ejemplo los labels de los campos del fomulario,
     * cabeceras de tablas, labels de botones, de links, etc...
     */

    // nombre del módulo
    'module' => [
        'name' => 'Productos',
        'short-name' => 'Productos',
        'name-singular' => 'Producto',
    ],

    // vista index
    'index' => [
        'name' => 'Index',

        // botonera
        'create-button-label' => 'Crear Producto',
        'delete-massively-button-label' => 'Borrar Productos seleccionados',
        'restore-massively-button-label' => 'Restaurar Seleccionados',

        // lineas de las opciones de filtros del fomulario de búsqueda
        'filter-with-trashed-label' => 'Con Reg. Borrados',
        'filter-only-trashed-label' => 'Sólo Reg. Borrados',

        // ventana modal de confirmación de la acción del botón restaurar registro
        'modal-restore-title' => 'Está seguro?',
        'modal-restore-message' => 'La información de <strong>:item</strong> será <strong>Restaurada</strong>...',
        'modal-restore-btn-confirm-label' => 'Restaurar',
        'modal-restore-btn-confirm-class-name' => 'btn-success',

        // ventana modal de confirmación para acción del botón restaurar registros masivamente
        'modal-restore-massively-title' => 'Está seguro?',
        'modal-restore-massively-message' => 'La información de los elementos seleccionados será <strong>Restaurada</strong>...',
        'modal-restore-massively-btn-confirm-label' => 'Restaurar Todos',
        'modal-restore-massively-btn-confirm-class-name' => 'btn-success',

        // ventana modal de confirmación de la acción del botón eliminar registro
        'modal-delete-title' => 'Está seguro?',
        'modal-delete-message' => 'La información de <strong>:item</strong> será <strong>BORRADA</strong>...',
        'modal-delete-btn-confirm-label' => 'Borrar',
        'modal-delete-btn-confirm-class-name' => 'btn-danger',

        // ventana modal de confirmación de la acción del botón eliminar registros masivamente
        'modal-delete-massively-title' => 'Está seguro?',
        'modal-delete-massively-message' => 'La información de los elementos seleccionados será <strong>BORRADA</strong>...',
        'modal-delete-massively-btn-confirm-label' => 'Borrar Todos',
        'modal-delete-massively-btn-confirm-class-name' => 'btn-danger',

        // los valores por defecto de las ventanas modales generadas con el componente Bootbox
        'modal-default-title' => 'Está Seguro?',
        'modal-default-btn-confirmation-label' => 'Confirmar',
        'modal-default-btn-confirmation-className' => 'btn-primary',
        'modal-default-btn-cancel-label' => 'Cancelar',
        'modal-default-btn-cancel-className' => 'btn-default',

        // botones y otros strings de la taba del index
        'filters-button-label' => 'Más Filtros',
        'search-button-label' => 'Buscar',
        'clean-filter-button-label' => 'Limpiar filtros',
        'see-details-button-label' => 'Ver detalles',
        'edit-item-button-label' => 'Editar registro',
        'delete-item-button-label' => 'Borrar registro',
        'create-form-modal-title' => 'Crear Nuevo Producto',
        'restore-row-button-label' => 'Restaurar',

        'table-actions-column' => 'Acciones',
        'no-records-found' => 'No se encontraron registros...',

        // para el componente Bootstrap dateRangePicker
        'dateRangePicker' => [
            'applyLabel' => 'Aplicar',
            'cancelLabel' => 'Limpiar',
            'fromLabel' => 'Desde',
            'toLabel' => 'Hasta',
            'separator' => ' - ',
            'weekLabel' => 'S',
            'customRangeLabel' => 'Personalizado',
            'daysOfWeek' => "['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa']",
            'monthNames' => "['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']",
            'firstDay' => '1',
            // rangos predeterminados
            'range_today' => 'Hoy',
            'range_yesterday' => 'Ayer',
            'range_last_7_days' => 'Últimos 7 días',
            'range_last_30_days' => 'Últimos 30 días',
            'range_this_month' => 'Este mes',
            'range_last_month' => 'Mes pasado',
        ],

        'x-editable' => [
            'dafaultValue' => '---',
        ],
    ],

    // vista create
    'create' => [
        'name' => 'Crear',
        'btn-create' => 'Crear',
    ],

    // vista edit
    'edit' => [
        'name' => 'Actualizar',
        'link-access' => 'Editar',
        'btn-edit' => 'Actualizar',
    ],

    // vista show
    'show' => [
        'name' => 'Detalles',
        'long-name' => 'Detalles de Producto',
        'btn-trash' => 'Mover a Papelera',
        'btn-edit' => 'Editar',
        'modal-confirm-trash-title' => 'Está Seguro?',
        'modal-confirm-trash-body' => 'La información de <strong>:item</strong> será movida a la papelera, sus datos no estarán disponibles...',
        'modal-confirm-trash-btn-confirm' => 'Confirmar',
        'modal-confirm-trash-btn-cancel' => 'Cancelar',
    ],

    // nombres de los elementos del formulario de creación/edición
    'form-fields' => [
        'id' => 'Id',
        'internal_code' => 'Código Interno *',
        'name' => 'Nombre *',
        'description' => 'Descripción *',
        'created_at' => 'Fecha de Creación',
        'updated_at' => 'Fecha de Actualización',
        'deleted_at' => 'Fecha de Eliminación',
    ],

    // nombres cortos de los elementos del formulario, para la tabla del index
    'form-fields-short-name' => [
        'id' => 'Id',
        'internal_code' => 'Cód. Interno',
        'name' => 'Nombre',
        'description' => 'Descripción',
        'created_at' => 'Fecha de Creación',
        'updated_at' => 'Fecha de Actualización',
        'deleted_at' => 'Fecha de Eliminación',
    ],

    // el formulario de búsqueda
    'search_form' => [
        'find' => 'Buscar...',
        'btn-search' => 'Buscar',
        'btn-clean' => 'Quitar Filtros',
    ],

    // otros mensajes
    'inputs-required-help' => 'Los campos marcados con <strong>*</strong> son requeridos.',

];
```

## Extra, configuraciones óptimas para Laravel en servidor Nginx

Cuando se crea un host virtual en Nginx, es recomendable dejar estas configuraciones para un mejor desempeño del servidor, eso si teniendo en cuenta que deben ser ajustadas a las necesidades de cada proyecto, muy importante correr el script que arregla los permisos de los ficheros y carpetas luego de correr estas configuraciones; el código acontinuaciòn mostrado está pensado para para un servidor local y con un host virtual llamado *testing.dev* con PHP7, se debe ajustar el `root` que apunte a la instalación de Laravel:

```nginx

server {
	listen 80; # poner aquí 'default_server' si es necesario
	listen [::]:80 ipv6only=on; # poner aquí 'default_server' si es necesario

	root /var/www/testing/public;
	index index.php index.html index.htm;

	server_name testing.dev www.testing.dev;
	charset   utf-8;

	gzip on;
	gzip_vary on;
	gzip_disable "msie6";
	gzip_comp_level 6;
	gzip_min_length 1100;
	gzip_buffers 16 8k;
	gzip_proxied any;
	gzip_types
		text/plain
		text/css
		text/js
		text/xml
		text/javascript
		application/javascript
		application/x-javascript
		application/json
		application/xml
		application/xml+rss;

	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~ \.php$ {
		try_files $uri /index.php =404;
		fastcgi_split_path_info ^(.+\.php)(/.+)$;
		#fastcgi_pass unix:/var/run/php5-fpm.sock; # Descomentar esta lìnea y comentar la siguiente si usas PHP5
		fastcgi_pass unix:/run/php/php7.0-fpm.sock;
		fastcgi_index index.php;
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
		include fastcgi_params;
	}

	location ~ /\.ht {
		deny all;
	}

	location ~* \.(?:jpg|jpeg|gif|png|ico|cur|gz|svg|svgz|mp4|ogg|ogv|webm|htc|svg|woff|woff2|ttf)$ {
		expires 1M;
		access_log off;
		add_header Cache-Control "public";
	}

	location ~* \.(?:css|js)$ {
		expires 7d;
		access_log off;
		add_header Cache-Control "public";
	}

}

```

### Vistas ###

Las vistas generadas hacen uso de varias dependencias frontend, que deberian ser agregadas al proyecto a través de Bower por ejemplo:

```json
  "dependencies": {
    "admin-lte": "^2",
    "bootstrap-switch": "^3",
    "bootstrap": "^3.3.6",
    "bootstrap-datepicker": "*",
    "bootstrap-select": "*",
    "bootbox": "*",
    "bootstrap-datetimepicker-master": "*",
    "eonasdan-bootstrap-datetimepicker": "*",
    "x-editable": "^1.5.1"
  }
```

Como se puede ver se usa como template [admin-lte](https://almsaeedstudio.com/themes/AdminLTE/index.html) el cual es un gran admin-template basado en [Bootstrap](http://getbootstrap.com/), todas las vistas están pensadas para usar este tema, aunque si no usas admin-lte nada malo debería pasar, haces unos cambios sencillos a las vistas generadas y ya. Recomiendo que sea revisada la documentación de cada uno de los paquetes frontend usados para conocer su funcionamiento y configuración, pues el código generado les configura de una forma básica.

Aquí algunas capturas de pantalla de la CRUD app generada para el ejemplo de la entidad Productos:

![Vista index con detalles de menú filtros](https://cloud.githubusercontent.com/assets/2442445/17460639/a3bbce3a-5c35-11e6-8d1a-027be443bb79.png)

![Vista index mostrando registros en papelera y gidwet de selector de fechas](https://cloud.githubusercontent.com/assets/2442445/17460640/a3bbd97a-5c35-11e6-8b1e-a6f75f3eb371.png)

![Tabla en vista index con paginación](https://cloud.githubusercontent.com/assets/2442445/17460636/a3a73718-5c35-11e6-8ce5-3174d489a394.png]

![Formulario de creación de registro en ventana modal](https://cloud.githubusercontent.com/assets/2442445/17460637/a3a8f44a-5c35-11e6-88e5-80ed14ac2b60.png)

![Confirmación para eliminar registro](https://cloud.githubusercontent.com/assets/2442445/17460638/a3a9edc8-5c35-11e6-9bfd-23008959e6e6.png]

![Confirmación para restaurar registro de papelera](https://cloud.githubusercontent.com/assets/2442445/17460633/a3a64d8a-5c35-11e6-9a10-0bb5c7955adc.png)

![Vista edit](https://cloud.githubusercontent.com/assets/2442445/17460634/a3a6b09a-5c35-11e6-9305-7f251a8cdcae.png)

![Vista show](https://cloud.githubusercontent.com/assets/2442445/17460635/a3a6c904-5c35-11e6-9808-1d244e1bf739.png)

## TODO

- Añadir funciones de exportación de información de los modelos en los formatos:
	- CSV
	- Excel
	- PDF
	- Print (vista para impresión)
- Añadir botón de cancelar en las vistas de crear y actualizar que redirijan al index del módulo.
- Añadir botón volver en vista de detalles (show).
- Añadir opción para crear el archivo de migración, en este caso lógicamente no se tendrá en cuenta la tabla en la base de datos.
- Hacer uso de los FormRequest de Laravel para la validación de formularios para cada método (store, update, delete, tal vez index).
- Añadir opción para que el usuario elija que tipo de buscador se desea en el index del módulo:
	- Un sólo elemento de formulario de búsqueda para todos los campos, formulario de búsqueda sencilla.
	- Elementos de formulario para cada campo del modelo, formulario de búsqueda avanzada.
- Dar opción para crear el CRUD con estructura modular, como si fuera un paquete de Laravel.
- Crear habilidad para que el usuario elija que campos desea mostrar en la tabla del index.
- Crear habilidad para dejar decirdir al usuario si quiere o no las ediciones inline en la tabla con el componente x-edititable de javascript.
- Añadir opción para añadir habilidad de protección de datos de registros al crear los ficheros.
- Añadir colores a la filas de la tabla del index dependiendo del estado del registro, ~~rojo para registros eliminados~~, amarillos para registros protegidos, etc... y añadir notas de estos