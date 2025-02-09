<?php

namespace App\Http\Controllers\Admin\AdminConsole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::query()
            ->withCount('childMenus')
            ->with('parentMenu')
            ->orderBy('id')
            ->orderBy('menu_order')
            ->get();

        return view('admin.admin-console.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.admin-console.menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'string|required|min:3|max:100',
            'menu_order' => 'integer|required|min:1',
            'group_name' => 'string|nullable',
            'menu_icon' => 'string|nullable',
            'route_name' => 'string|nullable',
            'menu_url' => 'string|nullable',
            'parent_menu_id' => 'integer|nullable',
            'is_active' => 'integer|in:1,0',
        ]);

        Menu::create($validated);

        return back()->with('success', 'Menu created successfully');
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'string|required|min:3|max:100',
            'menu_order' => 'integer|required|min:1',
            'group_name' => 'string|nullable',
            'menu_icon' => 'string|nullable',
            'route_name' => 'string|nullable',
            'menu_url' => 'string|nullable',
            'parent_menu_id' => 'integer|nullable',
            'is_active' => 'integer|in:1,0',
        ]);

        $menu->update($validated);

        return back()->with('success', 'Menu updated successfully');
    }
}
