<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // $prodi = ProgramStudi::all();
        return view(
            'admin.index',
            [
                // 'program_studi' => $prodi,
            ]
        );
    }

}
