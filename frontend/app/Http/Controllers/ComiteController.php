<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComiteController extends Controller
{
    public function index()
    {
        return view(
            'comite.index',[]
        );
    }

    public function add()
    {
        return view('comite.add');
    }

    public function store(Request $request)
    {
        return redirect(route('program_studi.index', absolute: false))
        ->with('status', 'Program Studi berhasil ditambahkan');
    }



    public function edit($id)
    {
        return view('comite.edit', []);
    }

    public function update(Request $request, $id)
    {
    }

    public function delete($id)
    {
    }
}
