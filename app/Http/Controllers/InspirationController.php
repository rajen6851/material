<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Inspiration;
use Illuminate\Http\Request;

class InspirationController extends Controller
{
    public function index(Request $request)
    {
        $activeFilter = $request->query('filter', 'all');

        $query = Inspiration::query();
        
        if ($activeFilter !== 'all') {
            $query->where('space', $activeFilter);
        }
        
        $filteredProjects = $query->latest()->get();
        $projects = Inspiration::latest()->get();

        $rooms = Room::all();

        return view('inspiration.index', [
            'projects' => $filteredProjects,
            'allProjects' => $projects,
            'activeFilter' => $activeFilter,
            'rooms' => $rooms,
        ]);
    }
}
