<?php
namespace App\View\Components;

use App\Models\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class TopNav extends Component
{
    public $menus;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // TODO: role wise menu
        $user = auth()->user();
        $user_id = $user ? $user->id : '';

        /* $this->menus = Menu::query()
            ->withCount('childMenus')
            ->with(['parentMenu', 'childMenus' => fn($query) => $query->active()])
            ->active()
            ->mainMenu()
            ->when($user->is_superuser === 0, fn($query) => $query->where('visible_to_all_user', 1))
            ->orderBy('menu_order')
            ->orderBy('id')
            ->get(); */

        $this->menus = Cache::remember('menus_'.$user_id, 60 * 60, function () use ($user) {
            return Menu::query()
                ->withCount('childMenus')
                ->with(['parentMenu', 'childMenus' => fn($query) => $query->active()])
                ->active()
                ->mainMenu()
                ->when($user && $user->is_superuser === 0, fn($query) => $query->where('visible_to_all_user', 1))
                ->orderBy('menu_order')
                ->orderBy('id')
                ->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.top-nav');
    }
}
