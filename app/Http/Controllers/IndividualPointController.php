<?php

namespace App\Http\Controllers;

use App\Http\Requests\Results\ByPoints\Individual\CreatePointRequest;
use App\Http\Requests\Results\ByPoints\Individual\UpdatePointRequest;
use App\Models\Events\Event;
use App\Models\Results\ByPoint;
use App\Models\Results\ByPointPlayerLocal;
use App\Models\Results\ByPointPlayerVisitor;
class IndividualPointController extends Controller
{
    public function create(CreatePointRequest $request, ByPoint $result)
    {
        if ($result->event->isPlayerLocal($request->post('player')))
            $this->createLocalPoint($request, $result);
        if ($result->event->isPlayerVisitor($request->post('player')))
            $this->createVisitorPoint($request, $result);

        return back()->with('statusCreate', 'Point created successfully.');
    }

    public function index(Event $event)
    {
        return view('results.by-points.individual.index', [
            'event' => $event
        ]);
    }

    public function editLocalPoint(ByPointPlayerLocal $point)
    {
        return view('results.by-points.individual.edit', [
            'point' => $point
        ]);
    }

    public function editVisitorPoint(ByPointPlayerVisitor $point)
    {
        return view('results.by-points.individual.edit', [
            'point' => $point
        ]);
    }

    public function updateLocalPoint(UpdatePointRequest $request, ByPointPlayerLocal $point)
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

    public function updateVisitorPoint(UpdatePointRequest $request, ByPointPlayerVisitor $point)
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

    public function deleteLocalPoint(ByPointPlayerLocal $point)
    {
        $point->delete();
        return back()->with([
            'statusDelete' => 'Point deleted successfully.',
            'deletedId' => $point->id,
            'side' => 'local',
        ]);
    }

    public function deleteVisitorPoint(ByPointPlayerVisitor $point)
    {
        $point->delete();
        return back()->with([
            'statusDelete' => 'Point deleted successfully.',
            'deletedId' => $point->id,
            'side' => 'visitor',
        ]);
    }

    public function restoreLocalPoint(ByPointPlayerLocal $point)
    {
        $point->restore();
        return back()->with('statusRestore', 'Point restored successfully.');
    }

    private function createLocalPoint($request, $result)
    {
        return ByPointPlayerLocal::create([
            'by_point_id' => $result->id,
            'event_id' => $result->event->id,
            'minute' => $request->post('minute'),
            $this->getPointOwner($request->post('isInFavor')) => $request->post('points')
        ]);
    }

    private function createVisitorPoint($request, $result)
    {
        return ByPointPlayerVisitor::create([
            'by_point_id' => $result->id,
            'event_id' => $result->event->id,
            'minute' => $request->post('minute'),
            $this->getPointOwner($request->post('isInFavor')) => $request->post('points')
        ]);
    }

    private function getPointOwner($isInFavor)
    {
        return $isInFavor ? 'points_in_favor' : 'points_against';
    }

    private function checkPointOwner($point)
    {
        if ($point->points_in_favor !== 0) return 'points_in_favor';
        if ($point->points_against !== 0) return 'points_against';
    }
}
