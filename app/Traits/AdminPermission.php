<?php

namespace App\Traits;

Trait AdminPermission{

    public function checkRequestPermission(){
        if (
            //Web Route
            empty(auth()->user()->role->permission['permission']['category']['index']) && \Route::is('category.index') ||
            empty(auth()->user()->role->permission['permission']['category']['destroy'])  && \Route::is('category.destroy') ||
            empty(auth()->user()->role->permission['permission']['product']['index']) && \Route::is('product.index') ||
            empty(auth()->user()->role->permission['permission']['product']['create'])  && \Route::is('product.create') ||
            empty(auth()->user()->role->permission['permission']['product']['edit'])  && \Route::is('product.edit') ||
            empty(auth()->user()->role->permission['permission']['product']['destroy'])  && \Route::is('product.destroy') ||
            empty(auth()->user()->role->permission['permission']['barcode']['index']) && \Route::is('barcode.index') ||
            empty(auth()->user()->role->permission['permission']['qr-code']['index']) && \Route::is('qr-code.index') ||
            empty(auth()->user()->role->permission['permission']['setting']['index']) && \Route::is('setting.index')||
            empty(auth()->user()->role->permission['permission']['role']['index']) && \Route::is('role.index') ||
            empty(auth()->user()->role->permission['permission']['role']['destroy'])  && \Route::is('role.destroy')||
            empty(auth()->user()->role->permission['permission']['permission']['index']) && \Route::is('permission.index') ||
            empty(auth()->user()->role->permission['permission']['permission']['create'])  && \Route::is('permission.create') ||
            empty(auth()->user()->role->permission['permission']['permission']['edit'])  && \Route::is('permission.edit') ||
            empty(auth()->user()->role->permission['permission']['permission']['destroy'])  && \Route::is('permission.destroy') ||
            empty(auth()->user()->role->permission['permission']['user']['index']) && \Route::is('user.index') ||
            empty(auth()->user()->role->permission['permission']['user']['destroy'])  && \Route::is('user.destroy')
           
            //Inventory Route

            //Account Route
        ) {
           return response()->view('backend.layouts.dashboard');
        }
    }


    // public function checkRequestPermission()
    // {
    //     $user = auth()->user();
    //     $permissions = $user->role->permission;

    //     $routeName = Route::currentRouteName();
    //     $route = $this->getRoutePermission($routeName);

    //     if ($route && !$this->hasPermission($permissions, $route)) {
    //         return response()->view('backend.layouts.dashboard'); // Redirect or show an error page
    //     }

    //     return null;
    // }

    // private function getRoutePermission($routeName)
    // {
    //     $routes = [
    //         'category.index' => 'category.index',
    //         'category.destroy' => 'category.destroy',
    //         'product.index' => 'product.index',
    //         'product.create' => 'product.add',
    //         'product.edit' => 'product.edit',
    //         'product.destroy' => 'product.destroy',
    //         'barcode.index' => 'barcode.index',
    //         'qr-code.index' => 'qr-code.index',
    //         'setting.index' => 'setting.index',
    //         'role.index' => 'role.index',
    //         'role.destroy' => 'role.destroy',
    //         'permission.index' => 'permission.index',
    //         'permission.create' => 'permission.add',
    //         'permission.edit' => 'permission.edit',
    //         'permission.destroy' => 'permission.destroy',
    //         'user.index' => 'user.index',
    //         'user.destroy' => 'user.destroy',
    //     ];

    //     return $routes[$routeName] ?? null;
    // }

    // private function hasPermission($permissions, $route)
    // {
    //     $permissionKeys = explode('.', $route);

    //     foreach ($permissionKeys as $key) {
    //         if (isset($permissions[$key]) && $permissions[$key] === '1') {
    //             return true;
    //         }
    //     }

    //     return false;
    // }
}
