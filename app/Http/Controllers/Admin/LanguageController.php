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

    /**
     * Delete a language and return book to language default.
     *
     * @param Language $language object language
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        // Can't delete default language
        if ($language->id == Language::LANGUAGE_DEFAULT) {
            flash(__('languages.delete_default_language_failure'))->warning();
            return redirect()->back();
        }
        $languageName = $language->language;
        try {
            $language->delete();
            flash(__('languages.delete_language_success', ['name' => $languageName]))->success();
        } catch (Exception $e) {
            \Log::error($e);
            flash(__('languages.delete_language_fail', ['name' => $languageName]))->error();
        }
        return redirect()->back();
    }
}
