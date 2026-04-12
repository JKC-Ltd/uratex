<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Response;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();

        return view('pages.configurations.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.configurations.branches.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(self::formRule(), self::errorMessage(), self::changeAttributes());

        DB::enableQueryLog();

        $branch = new Branch($request->all());
        $branch->save();

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        // Not used currently.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('pages.configurations.branches.form', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate(self::formRule($branch->id), self::errorMessage(), self::changeAttributes());

        DB::enableQueryLog();

        $branch->update($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::enableQueryLog();

        $id = $request->id;
        $branch = Branch::findOrFail($id);
        $branch->save();
        $branch->delete();

        return Response::json($branch);
    }

    public function formRule($id = false)
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('branches')->ignore($id, 'id')],
            'branch_code' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function errorMessage()
    {
        return [
            'name.required' => 'Branch Name is required',
            'name.unique' => 'Branch Name already exists',
            'branch_code.max' => 'Branch Code may not be greater than 255 characters',
        ];
    }

    public function changeAttributes()
    {
        return [
            'name' => 'Branch Name',
            'branch_code' => 'Branch Code',
        ];
    }
}
