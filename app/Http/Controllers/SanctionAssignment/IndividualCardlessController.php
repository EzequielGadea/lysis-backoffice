<?php

namespace App\Http\Controllers\SanctionAssignment;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sanctions\Assignment\Individual\CardlessSanctionCreateRequest;
use App\Http\Requests\Sanctions\Assignment\Individual\CardlessSanctionUpdateRequest;
use App\Models\Events\Event;
use App\Models\Events\PlayerLocalSanctionCardless as LocalSanction;
use App\Models\Events\PlayerLocalSanctionCardlessSet as LocalSanctionSet;
use App\Models\Events\PlayerVisitorSanctionCardless as VisitorSanction;
use App\Models\Events\PlayerVisitorSanctionCardlessSet as VisitorSanctionSet;
use App\Models\Sanctions\SanctionCardless;

class IndividualCardlessController extends Controller
{
    private $bySetResultType = '3';

    public function create(CardlessSanctionCreateRequest $request, Event $event)
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
        } catch (QueryException $e) {
            return back()->with('statusCreate', 'Error while creating sanction.');
        }

        return back()->with('statusCreate', 'Sanction created successfully');
    }

    public function index(Event $event)
    {
        return view('sanctions.cardless.individual.index', [
            'event' => $event,
            'sanctions' => SanctionCardless::all(),
        ]);
    }

    public function editLocal(LocalSanction $sanction)
    {
        return view('sanctions.cardless.individual.edit', [
            'sanction' => $sanction,
            'sanctions' => SanctionCardless::all(),
            'side' => 'local',
        ]);
    }

    public function editVisitor(VisitorSanction $sanction)
    {
        return view('sanctions.cardless.individual.edit', [
            'sanction' => $sanction,
            'sanctions' => SanctionCardless::all(),
            'side' => 'visitor',
        ]);
    }

    public function updateLocal(CardlessSanctionUpdateRequest $request, LocalSanction $sanction)
    {
        $sanction->update([
            'sanction_cardless_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);

        if ($sanction->event->result()->result_type_id == $this->bySetResultType) {
            $sanction->inSet->update([
                'set' => $request->post('set'),
            ]);
        }

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

        if ($sanction->event->result()->result_type_id == $this->bySetResultType) {
            $sanction->inSet->update([
                'set' => $request->post('set'),
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

    private function createVisitorSet($request, $visitorSanction) {
        return VisitorSanctionSet::create([
            'player_visitor_sanction_cardless_id' => $visitorSanction->id,
            'set_id' => $request->post('set'),
        ]);
    }
    
    private function createLocalSet($request, $localSanction) {
        return LocalSanctionSet::create([
            'player_local_sanction_cardless_id' => $localSanction->id,
            'set_id' => $request->post('set'),
        ]);
    }
}
