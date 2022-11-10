<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Common\Unit;

class UnitController extends Controller
{
    public function create(UnitRequest $request)
    {
        Unit::create($request->validated());
        return back()->with('statusCreate', 'Unit created successfully');
    }

    public function index()
    {
        return view('units.index', [
            'units' => Unit::all()
        ]);
    }

    public function edit(Unit $unit)
    {
        return view('units.update', [
            'unit' => $unit
        ]);
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return back()->with([
            'statusUpdate' => 'Unit updated successfully.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Unit $unit)
    {
        $unit->delete();
        return back()->with([
            'statusDelete' => 'Unit deleted successfully.',
            'deletedId' => $unit->id
        ]);
    }

    public function restore($id)
    {
        Unit::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('statusRestore', 'Unit restored successfully');
    }
}
