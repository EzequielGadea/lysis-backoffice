<?php

namespace App\Http\Controllers;

use App\Services\ByMarkService;
use App\Http\Requests\ResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Models\Events\Event;
use App\Models\Results\ByMarkPlayerLocal;
use App\Models\Results\ByMarkPlayerVisitor;

class MarkController extends Controller
{
    private $service;

    public function __construct(ByMarkService $service)
    {
        $this->service = $service;
    }

    public function create(ResultRequest $request, Event $event)
    {
        $this->service->create($request, $event);
        return back()->with('statusCreate', 'Result created successfully.');
    }

    public function show(Event $event)
    {
        return view('results.result-management', [
            'event' => $event,
            'resultTypes' => [
                'byMark' => '1',
                'byPoints' => '2',
                'bySets' => '3'
            ]
        ]);
    }

    public function editPlayerLocal(ByMarkPlayerLocal $playerMark)
    {
        return view('results.result-update', [
            'playerMark' => $playerMark
        ]);
    }

    public function editPlayerVisitor(ByMarkPlayerVisitor $playerMark)
    {
        return view('results.result-update', [
            'playerMark' => $playerMark
        ]);
    }

    public function deletePlayerLocal(ByMarkPlayerLocal $playerMark)
    {
        $playerMark->delete();
        return back()->with([
            'statusDelete' => 'Mark deleted successfully.',
            'deletedId' => $playerMark->id,
            'sideDeleted' => 'local'
        ]);
    }

    public function deletePlayerVisitor(ByMarkPlayerVisitor $playerMark)
    {
        $playerMark->delete();
        return back()->with([
            'statusDelete' => 'Mark deleted successfully.',
            'deletedId' => $playerMark->id,
            'sideDeleted' => 'visitor'
        ]);
    }

    public function restorePlayerLocal($id)
    {
        ByMarkPlayerLocal::onlyTrashed()
            ->findOrFail($id)
            ->restore();
        return back()->with('statusRestore', 'Mark restored successfully.');
    }

    public function restorePlayerVisitor($id)
    {
        ByMarkPlayerVisitor::onlyTrashed()
            ->findOrFail($id)
            ->restore();
        return back()->with('statusRestore', 'Mark restored successfully.');
    }

    public function updatePlayerLocal(ByMarkPlayerLocal $playerMark, UpdateResultRequest $request)
    {
        $playerMark->update([
            'mark_value' => $request->post('markValue')
        ]);
        return back()->with([
            'statusUpdate' => 'Mark updated successfully.',
            'isRedirected' => 'true'
        ]);
    }

    public function updatePlayerVisitor(ByMarkPlayerVisitor $playerMark, UpdateResultRequest $request)
    {
        $playerMark->update([
            'mark_value' => $request->post('markValue')
        ]);
        return back()->with([
            'statusUpdate' => 'Mark updated successfully.',
            'isRedirected' => 'true'
        ]);
    }
}
