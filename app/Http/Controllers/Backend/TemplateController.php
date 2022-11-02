<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $templates = Template::latest()->paginate(25);
        return view('backend.template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $plans = Plan::all();
        return view('backend.template.create', compact('plans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required'
        ]);

        $template = Template::create($request->all());
        $template->plans()->sync($request->plans);

        return redirect()->route('backend.templates.index')->with('Template Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Template $template
     * @return Response
     */
    public function show(Template $template)
    {
        return view('backend.template.show', compact('template'));
    }


    public function edit(Template $template)
    {
        $plans = Plan::all();
        return  view('backend.template.edit', compact('template', 'plans'));
    }


    public function update(Request $request, Template $template)
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required'
        ]);

        $template->update($request->all());
        $template->plans()->sync($request->plans);
        return redirect()->back()->with('success', 'Template Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Template $template
     * @return Response
     */
    public function destroy(Template $template)
    {
        $template->delete();
        return redirect()->back()->with('success', 'Template Deleted Successfully!');
    }
}
