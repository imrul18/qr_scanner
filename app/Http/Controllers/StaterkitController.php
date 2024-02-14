<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

class StaterkitController extends Controller
{
    // home
    public function home()
    {
        //        return auth()->user();
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Index"]
        ];
        return view('content.home', ['breadcrumbs' => $breadcrumbs]);
    }

    public function homeNew()
    {
        $user = User::with('refer')->with('orders', function ($q) {
            $q->with('seller')->latest()->take(5);
        })->find(auth()->user()->id);
        $result = User::buildTree($user->ref_code);
        $countAllNodes = User::countAllNodes($user->ref_code);
        $self = $user;
        $self['children'] = $result;
        $tree = [$self];
        $userList = User::all();
        $order = [];
        //total orders amount
        // $order['total_amount'] = Order::sum('total_price');
        //total RP amount of orders
        // $order['total_rp_amount'] = Order::sum('repurchase_price');
        return view('pages.users.profile', compact('user', 'tree', 'countAllNodes', 'userList', 'order'));
    }

    // Layout collapsed menu
    public function collapsed_menu()
    {
        $pageConfigs = ['sidebarCollapsed' => true];
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Collapsed menu"]
        ];
        return view('/content/layout-collapsed-menu', ['breadcrumbs' => $breadcrumbs, 'pageConfigs' => $pageConfigs]);
    }

    // layout boxed
    public function layout_full()
    {
        $pageConfigs = ['layoutWidth' => 'full'];

        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Layouts"], ['name' => "Layout Full"]
        ];
        return view('/content/layout-full', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs]);
    }

    // without menu
    public function without_menu()
    {
        $pageConfigs = ['showMenu' => false];
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout without menu"]
        ];
        return view('/content/layout-without-menu', ['breadcrumbs' => $breadcrumbs, 'pageConfigs' => $pageConfigs]);
    }

    // Empty Layout
    public function layout_empty()
    {
        $breadcrumbs = [['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout Empty"]];
        return view('/content/layout-empty', ['breadcrumbs' => $breadcrumbs]);
    }
    // Blank Layout
    public function layout_blank()
    {
        $pageConfigs = ['blankPage' => true];
        return view('/content/layout-blank', ['pageConfigs' => $pageConfigs]);
    }
}
