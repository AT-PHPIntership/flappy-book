<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EditLanguageRequest;
use App\Model\Language;
use DB;

class LanguageController extends Controller
{

    /**
     * Display a list of the languages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'languages.id',
            'languages.language',
        ];
        $languages = Language::select($fields)
                        ->paginate(config('define.languages.limit_rows'));

        return view('backend.languages.index', compact('languages'));
    }

    /**
     * Update infomation of Language.
     *
     * @param App\Http\Requests\Backend\EditLanguageRequest $request  request
     * @param App\Model\Language                            $language language
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditLanguageRequest $request, Language $language)
    {
        $result = $language->update($request->only('language'));
        return response(array('result' => $result));
    }
}
