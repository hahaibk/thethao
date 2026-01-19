<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Sport;

class CategoryAjaxController extends Controller
{
    public function bySport(Sport $sport)
    {
        return response()->json(
            $sport->categories()
                ->select('id', 'name', 'has_color', 'has_size')
                ->orderBy('name')
                ->get()
        );
    }
}
