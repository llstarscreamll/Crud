<?php

namespace llstarscreamll\CrudGenerator\App\Sidebar;

use Maatwebsite\Sidebar\Badge;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group('', function (Group $group) {
            $group->item('Crud Generator', function (Item $item) {
                $item->icon('fa fa-magic');
                $item->weight(0);
                $item->route('crudGenerator.index');
                $item->authorize(
                    // TODO:
                    // - Crear seed con permisos para este módulo
                    
                    //\Auth::user()->can('imageGallery.index')
                    true
                );
            });
        });

        return $menu;
    }
}
