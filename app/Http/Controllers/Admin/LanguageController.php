<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageCreateRequest;
use App\Http\Requests\Admin\LanguageUpdateRequest;
use App\Language;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $data['languages'] = LanguageRepository::all()->ordered()->get();

        return view('admin.languages.index')->with($data);
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(LanguageCreateRequest $request)
    {
        LanguageRepository::create($request->all());

        return redirect()->route('admin.languages.index');
    }

    public function edit(Language $language)
    {
        $data['language'] = $language;

        return view('admin.languages.edit')->with($data);
    }

    public function update(LanguageUpdateRequest $request, Language $language)
    {
        //ToDo update slugs
        $language->repository()->update($request->all());

        return redirect()->route('admin.languages.index');
    }
}
