<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Models\UserData;

class PublicFormController extends Controller
{

    public function index()
    {
        $forms = Form::all();
        return view('public.forms.list', compact('forms'));
    }

    public function show(Form $form)
    {
        return view('public.forms.show', compact('form'));
    }

    public function submit(Request $request, Form $form)
    {
        $validatedData = $request->validate([
            'fields.*' => 'required',
        ]);

        $userData = [];

        foreach ($validatedData['fields'] as $fieldId => $value) {
            $userData[$fieldId] = $value;
        }

        UserData::create([
            'form_id' => $form->id,
            'data' => $userData,
        ]);

        return redirect()->route('public.forms.show', $form)->with('success', 'Form submitted successfully!');
    }
}
