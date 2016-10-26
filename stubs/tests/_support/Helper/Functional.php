<?php
namespace Helper;

class Functional extends \Codeception\Module
{
    /**
     * Carga ruta destroy de un recurso con el método DELETE, se le pasará array
     * de ids para eliminar varios registros a la vez.
     *
     * @param  string $route La ruta destroy a cargar.
     * @param  array  $ids   Los ids de los registros a eliminar.
     */
    public function destroyMany(string $route, array $ids)
    {
        $url = route($route, 0);
        $data = [
            'id' => $ids,
            '_token' => csrf_token()
        ];

        $this->loadPage('DELETE', $url, $data);
    }

    /**
     * Carga ruta restore de un recurso con el método PUT, se le pasará array de
     * ids para restaurar varios registros a la vez.
     *
     * @param  string $route La ruta restore a cargar.
     * @param  array  $ids   Los ids de los registros a restaurar.
     */
    public function restoreMany(string $route, array $ids)
    {
        $url = route($route, 0);
        $data = [
            'id' => $ids,
            '_token' => csrf_token()
        ];

        $this->loadPage('PUT', $url, $data);
    }

    /**
     * Carga la página especificada en $url con el método dado en $method y se
     * le pasan los parámetros especificados en $data.
     *
     * @param  string $method  El método de la petición.
     * @param  string $url     La url a cargar.
     * @param  array  $data    Los parámetros para la url.
     */
    public function loadPage(string $method, string $url, array $data)
    {
        $this->getModule('Laravel5')->_loadPage($method, $url, $data);
    }
}
