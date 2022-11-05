<?php

namespace App\Http\Controllers;

use App\Http\Requests\Result\BySet\Individual\CreatePointRequest;
use App\Http\Requests\Result\BySet\Individual\UpdatePointRequest;
use App\Models\Events\Event;
use App\Models\Results\BySet;
use App\Models\Results\PlayerLocalSet;
use App\Models\Results\PlayerVisitorSet;

class IndividualSetController extends Controller
{
    public function create(CreatePointRequest $request, BySet $result)
    {
        if ($result->event->isPlayerLocal($request->post('player'))) 
            $this->createLocalPoint($request, $result);

        if ($result->event->isPlayerVisitor($request->post('player')))
            $this->createVisitorPoint($request, $result);

        return back()->with('statusCreate', 'Point created successfully.');
    }

    public function index(Event $event)
    {
        return view('results.bySet.individual.management', [
            'event' => $event
        ]);
    }

    public function editLocalPoint(PlayerLocalSet $point)
    {
        return view('results.bySet.individual.edit', [
            'point' => $point
        ]);
    }

    public function editVisitorPoint(PlayerVisitorSet $point)
    {
        return view('results.bySet.individual.edit', [
            'point' => $point
        ]);
    }

    public function updateLocalPoint(UpdatePointRequest $request, PlayerLocalSet $point)
    {
        $point->update([
            'minute' => $request->post('minute'),
            $this->checkPointOwner($point) => $request->post('points')       
        ]);
        return back()->with([
            'statusUpdate' => 'Point updated successfully.',
            'isRedirected' => 'true'
        ]);
    }

    public function updateVisitorPoint(UpdatePointRequest $request, PlayerVisitorSet $point)
    {
        $point->update([
            'minute' => $request->post('minute'),
            $this->checkPointOwner($point) => $request->post('points')       
        ]);
        return back()->with([
            'statusUpdate' => 'Point updated successfully.',
            'isRedirected' => 'true'
        ]);
    }

    public function deleteLocalPoint(PlayerLocalSet $point)
    {
        $point->delete();
        return back()->with([
            'statusDelete' => 'Point deleted successfully.',
            'side' => 'local',
            'deletedId' => $point->id
        ]);
    }

    public function deleteVisitorPoint(PlayerVisitorSet $point)
    {
        $point->delete();
        return back()->with([
            'statusDelete' => 'Point deleted successfully.',
            'side' => 'visitor',
            'deletedId' => $point->id
        ]);
    }

    public function restoreLocalPoint(PlayerLocalSet $point)
    {
        $point->restore();
        return back()->with([
            'statusRestore' => 'Point restored successfully.',
            'deletedId' => $point->id
        ]);
    }

    public function restoreVisitorPoint(PlayerVisitorSet $point)
    {
        $point->restore();
        return back()->with([
            'statusRestore' => 'Point restored successfully.',
            'deletedId' => $point->id
        ]);
    }

    private function createVisitorPoint($request, $result)
    {
        return PlayerVisitorSet::create([
            'set_id' => $request->post('set'),
            'event_id' => $result->event->id,
            'minute' => $request->post('minute'),
            $this->getPointOwner($request->post('isInFavor')) => $request->post('points'),
        ]);
    }

    private function createLocalPoint($request, $result)
    {
        return PlayerLocalSet::create([
            'set_id' => $request->post('set'),
            'event_id' => $result->event->id,
            'minute' => $request->post('minute'),
            $this->getPointOwner($request->post('isInFavor')) => $request->post('points'),
        ]);
    }

    private function getPointOwner($isInFavor)
    {
        return $isInFavor ? 'points_in_favor' : 'points_against';
    }

    private function checkPointOwner($point)
    {
        if ($point->poinst_in_favor !==0) return 'points_in_favor';
        if ($point->points_against !== 0) return 'points_against';
    }
}
