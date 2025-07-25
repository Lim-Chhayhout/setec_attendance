<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function contentStudent($page)
    {
        if (!in_array($page, ['home', 'scan', 'attendance'])) {
            abort(404);
        }

        return view("student.$page");
    }

    public function contentTeacher($page)
    {
        if (!in_array($page, ['home', 'attendanceqrcode', 'attendance'])) {
            abort(404);
        }

        return view("teacher.$page");
    }
}
