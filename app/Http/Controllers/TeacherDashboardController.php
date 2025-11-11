<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    /**
     * Display the teacher dashboard.
     */
    public function index()
    {

        $resourceStats = app(ResourceController::class)->getStats();

        return view('dashboards.teacher', compact('resourceStats'));
    }
}
