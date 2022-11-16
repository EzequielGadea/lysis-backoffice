<?php

namespace App\Http\Controllers\SanctionAssignment;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sanctions\Assignment\Individual\CardSanctionCreateRequest;
use App\Http\Requests\Sanctions\Assignment\Individual\CardSanctionUpdateRequest;
use App\Models\Events\Event;
use App\Models\Events\PlayerLocalSanctionCard as LocalSanction;
use App\Models\Events\PlayerVisitorSanctionCard as VisitorSanction;
use App\Models\Events\PlayerVisitorSanctionCardSet as VisitorSanctionSet;
use App\Models\Events\PlayerLocalSanctionCardSet as LocalSanctionSet;
Use App\Models\Sanctions\SanctionCard;

class IndividualCardController extends Controller
{
    private $bySetResultType = '3';

    public function create(CardSanctionCreateRequest $request, Event $event)
    {
        try {
            DB::transaction(function () use ($request, $event) {
                if ($event->isPlayerLocal($request->post('player'))) {
                    $sanction = $this->createLocal($request, $event);

                    if ($event->result()->result_type_id == $this->bySetResultType) {
                        $this->createLocalSet($request, $sanction);
                    }
                }
        
                if ($event->isPlayerVisitor($request->post('player'))) {
                    $sanction = $this->createVisitor($request, $event);

                    if ($event->result()->result_type_id == $this->bySetResultType) {
                        $this->createVisitorSet($request, $sanction);
                    }
                }
            });
        } catch (QueryException $th) {
            return back()->with('statusCreate', 'Error while creating sanction.');
        }


        return back()->with('statusCreate', 'Sanction created successfully.');
    }

    public function index(Event $event)
    {
        return view('sanctions.cards.individual.index', [
            'event' => $event,
            'cards' => SanctionCard::all(),
        ]);
    }

    public function editLocal(LocalSanction $sanction)
    {
        return view('sanctions.cards.individual.edit', [
            'sanction' => $sanction,
            'cards' => SanctionCard::all(),
            'side' => 'local',
        ]);
    }

    public function editVisitor(VisitorSanction $sanction)
    {
        return view('sanctions.cards.individual.edit', [
            'sanction' => $sanction,
            'cards' => SanctionCard::all(),
            'side' => 'visitor',
        ]);
    }

    public function updateLocal(CardSanctionUpdateRequest $request, LocalSanction $sanction)
    {
        $sanction->update([
            'sanction_card_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);

        if ($sanction->event->result()->result_type_id == $this->bySetResultType) {
            $sanction->inSet->update([
                'set_id' => $request->post('set')
            ]);
        }

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

        if ($sanction->event->result()->result_type_id == $this->bySetResultType) {
            $sanction->inSet->update([
                'set_id' => $request->post('set')
            ]);
        }

        return back()->with([
            'statusUpdate' => 'Sanction updated successfully.',
            'isRedirected' => 'true',
        ]);
    }

    public function deleteLocal(LocalSanction $sanction)
    {
        if ($sanction->event->result()->result_type_id == $this->bySetResultType) $sanction->inSet->delete();
        $sanction->delete();
        return back()->with([
            'statusDelete' => 'Sanction deleted successfully.',
            'deletedId' => $sanction->id,
            'side' => 'local',
        ]);
    }

    public function deleteVisitor(VisitorSanction $sanction)
    {
        if ($sanction->event->result()->result_type_id == $this->bySetResultType) $sanction->inSet->delete();
        $sanction->delete();
        return back()->with([
            'statusDelete' => 'Sanction deleted successfully.',
            'deletedId' => $sanction->id,
            'side' => 'visitor',
        ]);
    }

    public function restoreLocal(LocalSanction $sanction)
    {
        if ($sanction->event->result()->result_type_id == $this->bySetResultType) $sanction->inSet()->withTrashed()->restore();
        $sanction->restore();
        return back()->with('statusRestore', 'Sanction restored successfully.');
    }

    public function restoreVisitor(VisitorSanction $sanction)
    {
        if ($sanction->event->result()->result_type_id == $this->bySetResultType) $sanction->inSet()->withTrashed()->restore();
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

    private function createVisitorSet($request, $visitorSanction) {
        return VisitorSanctionSet::create([
            'player_visitor_sanction_card_id' => $visitorSanction->id,
            'set_id' => $request->post('set'),
        ]);
    }
    
    private function createLocalSet($request, $localSanction) {
        return LocalSanctionSet::create([
            'player_local_sanction_card_id' => $localSanction->id,
            'set_id' => $request->post('set'),
        ]);
    }
}
