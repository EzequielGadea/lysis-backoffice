<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultRequest;
use App\Models\Events\Event;
use App\Models\Results\ByMarkEventPlayerTeam;
use App\Models\Results\ByMarkPlayerLocal;
use App\Models\Results\ByMarkPlayerVisitor;
use App\Services\ByMarkService;
use App\Services\ByPointService;
use App\Services\BySetService;
use Illuminate\Http\Request;

class ResultController extends Controller
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

    public function edit($mark, $role)
    {
        if ($role == 'visitor')
            $playerMark = ByMarkPlayerVisitor::findOrFail($mark);
        if ($role == 'local')
            $playerMark = ByMarkPlayerLocal::findOrFail($mark);
        return $this->service->edit($playerMark, $role);
    }

    public function update(Event $event, Request $request, $playerMark, $role)
    {
        if ($role == 'visitor')
            $mark = ByMarkPlayerVisitor::find($playerMark);
        if ($role == 'local')
            $mark = ByMarkPlayerLocal::find($playerMark);
        if ($role = 'teams')
            $mark = ByMarkEventPlayerTeam::find($playerMark);
        return $this->service->update($event, $mark, $request);
    }
}
