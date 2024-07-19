<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendFormCreatedNotification;
use App\Models\Form;
use App\Models\Field;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return view('admin.forms.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.forms.create');
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:forms',
            'fields' => 'required|array',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.type' => 'required|string|max:255',
            'fields.*.options' => 'nullable|array',
            'fields.*.options.*' => 'required_if:fields.*.type,select',
        ]);
        $form = Form::create(['name' => $request->name]);

        foreach ($request->fields as $field) {
            Field::create([
                'form_id' => $form->id,
                'label' => $field['label'],
                'type' => $field['type'],
                'options' => $field['options'] ?? [],
            ]);
        }
        SendFormCreatedNotification::dispatch($form);

        return redirect()->route('forms.create')->with('success', 'Form created successfully.');
    }
    public function edit($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        return view('admin.forms.edit', compact('form'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Form $form
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Form $form)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:forms,name,' . ($form->id ?: 'NULL'),
            'fields' => 'required|array',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.type' => 'required|string|max:255',
            'fields.*.options' => 'nullable|array',
            'fields.*.options.*' => 'required_if:fields.*.type,select',
        ]);
        foreach ($validatedData['fields'] as $key => $field) {
            if ($field['type'] === 'select' && empty($field['options'])) {
                return redirect()->route('forms.edit', $form)->withErrors(['fields.' . $key . '.options' => 'Options are required for select fields.'])->withInput();
            }
        }

        $form->update(['name' => $request->name]);

        $form->fields()->delete();

        foreach ($request->fields as $field) {
            Field::create([
                'form_id' => $form->id,
                'label' => $field['label'],
                'type' => $field['type'],
                'options' => $field['options'] ?? [],
            ]);
        }
        return redirect()->route('forms.edit', $form)->with('success', 'Form updated successfully!');
    }

    public function destroy(Form $form)
    {
        $form->delete();

        // Redirect back to the forms index page with a success message
        return redirect()->route('forms.index')->with('success', 'Form deleted successfully!');
    }
}
