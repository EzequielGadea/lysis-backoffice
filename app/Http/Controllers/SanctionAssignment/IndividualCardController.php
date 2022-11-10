<?php

namespace App\Http\Controllers\SanctionAssignment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanctions\Assignment\Individual\CardSanctionCreateRequest;
use App\Http\Requests\Sanctions\Assignment\Individual\CardSanctionUpdateRequest;
use App\Models\Events\Event;
use App\Models\Events\PlayerLocalSanctionCard as LocalSanction;
use App\Models\Events\PlayerVisitorSanctionCard as VisitorSanction;

class IndividualCardController extends Controller
{
    public function create(CardSanctionCreateRequest $request, Event $event)
    {
        if ($event->isPlayerLocal($request->post('player'))) {
            $this->createLocal($request, $event);
        }

        if ($event->isPlayerVisitor($request->post('player'))) {
            $this->createVisitor($request, $event);
        }

        return back()->with('statusCreate', 'Sanction created successfully.');
    }

    public function index(Event $event)
    {
        return view('sanctions.card.index', [
            'event' => $event,
        ]);
    }

    public function editLocal(LocalSanction $sanction)
    {
        return view('sanctions.card.edit', [
            'sanction' => $sanction,
        ]);
    }

    public function editVisitor(VisitorSanction $sanction)
    {
        return view('sanctions.card.edit', [
            'sanction' => $sanction,
        ]);
    }

    public function updateLocal(CardSanctionUpdateRequest $request, LocalSanction $sanction)
    {
        $sanction->update([
            'sanction_card_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);

        return back()->with([
            'statusUpdate' => 'Sanction updated successfully.',
            'isRedirected' => 'true',
        ]);
    }

    public function updateVisitor(CardSanctionUpdateRequest $request, VisitorSanction $sanction)
    {
        $sanction->update([
            'sanction_card_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);

        return back()->with([
            'statusUpdate' => 'Sanction updated successfully.',
            'isRedirected' => 'true',
        ]);
    }

    public function deleteLocal(LocalSanction $sanction)
    {
        $sanction->delete();
        return back()->with('statusDelete', 'Sanction deleted successfully.');
    }

    public function deleteVisitor(VisitorSanction $sanction)
    {
        $sanction->delete();
        return back()->with('statusDelete', 'Sanction deleted successfully.');
    }

    public function restoreLocal(LocalSanction $sanction)
    {
        $sanction->restore();
        return back()->with('statusRestore', 'Sanction restored successfully.');
    }

    public function restoreVisitor(VisitorSanction $sanction)
    {
        $sanction->restore();
        return back()->with('statusRestore', 'Sanction restored successfully.');
    }

    private function createLocal($request, $event)
    {
        return LocalSanction::create([
            'event_id' => $event->id,
            'sanction_card_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);
    }

    private function createVisitor($request, $event)
    {
        return VisitorSanction::create([
            'event_id' => $event->id,
            'sanction_card_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);
    }
}
