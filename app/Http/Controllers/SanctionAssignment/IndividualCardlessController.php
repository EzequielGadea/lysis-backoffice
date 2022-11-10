<?php

namespace App\Http\Controllers\SanctionAssignment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanctions\Assignment\Individual\CardlessSanctionCreateRequest;
use App\Http\Requests\Sanctions\Assignment\Individual\CardlessSanctionUpdateRequest;
use App\Models\Events\Event;
use App\Models\Events\PlayerLocalSanctionCardless as LocalSanction;
use App\Models\Events\PlayerVisitorSanctionCardless as VisitorSanction;

class IndividualCardlessController extends Controller
{
    public function create(CardlessSanctionCreateRequest $request, Event $event)
    {
        if ($event->isPlayerLocal($request->post('player'))) {
            $this->createLocal($request, $event);
        }

        if ($event->isPlayerVisitor($request->post('player'))) {
            $this->createVisitor($request, $event);
        }

        return back()->with('statusCreate', 'Sanction created successfully');
    }

    public function index(Event $event)
    {
        return view('sanctions.cardless.index', [
            'event' => $event
        ]);
    }

    public function editLocal(LocalSanction $sanction)
    {
        return view('sanctions.edit-cardless', [
            'sanction' => $sanction,
        ]);
    }

    public function editVisitor(VisitorSanction $sanction)
    {
        return view('sanctions.edit-cardless', [
            'sanction' => $sanction,
        ]);
    }

    public function updateLocal(CardlessSanctionUpdateRequest $request, LocalSanction $sanction)
    {
        $sanction->update([
            'sanction_cardless_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);

        return back()->with([
            'statusUpdate' => 'Sanction updated successfully.',
            'isRedirected' => 'true',
        ]);
    }

    public function updateVisitor(CardlessSanctionUpdateRequest $request, VisitorSanction $sanction)
    {
        $sanction->update([
            'sanction_cardless_id' => $request->post('sanction'),
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
        return back()->with([
            'deleteStatus' => 'Sanction deleted successfully.',
            'deletedId' => $sanction->id,
        ]);
    }

    public function deleteVisitor(VisitorSanction $sanction)
    {
        $sanction->delete();
        return back()->with([
            'deleteStatus' => 'Sanction deleted successfully.',
            'deletedId' => $sanction->id,
        ]);
    }

    public function restoreLocal(LocalSanction $sanction)
    {
        $sanction->restore();
        return back()->with('restoreStatus', 'Sanction restored successfully.');
    }

    public function restoreVisitor(VisitorSanction $sanction)
    {
        $sanction->restore();
        return back()->with('restoreStatus', 'Sanction restored successfully.');
    }

    private function createLocal($request, $event)
    {
        return LocalSanction::create([
            'event_id' => $event->id,
            'sanction_cardless_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);
    }

    private function createVisitor($request, $event)
    {
        return VisitorSanction::create([
            'event_id' => $event->id,
            'sanction_cardless_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);
    }
}
