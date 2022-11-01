<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultRequest;
use App\Models\Events\Event;
use App\Services\ByMarkService;
use App\Services\ByPointService;
use App\Services\BySetService;

class ResultController extends Controller
{
    public function create(ResultRequest $request, Event $event, ByMarkService $service)
    {
        $service->create($request, $event);
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
}
