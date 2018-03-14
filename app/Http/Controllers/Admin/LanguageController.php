<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateLanguageRequest;
use App\Model\Language;

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
     * Store a newly created resource in storage.
     *
     * @param CreateLanguageRequest $request $request
     *
     * @return void
     */
    public function store(CreateLanguageRequest $request)
    {
        $language = $request->language;
        try {
            Language::create([
                'language' => $language,
            ]);
            flash(__('languages.add_language_success', ['name' => $language]))->success();
        } catch (Exception $e) {
            \Log::error($e);
            flash(__('languages.add_language_fail', ['name' => $language]))->error();
        }
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
