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
        return view('backend.languages.index');
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
        DB::beginTransaction();
        $result = false;
        try {
            $result = $language->update($request->only('language'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return response(array('result' => $result));
    }
}
