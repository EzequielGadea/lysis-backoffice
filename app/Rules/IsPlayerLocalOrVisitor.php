<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class IsPlayerLocalOrVisitor implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $isPlayerLocal = DB::table('player_local')->where([
            ['player_id', $value],
            ['event_id', request()->route('result')->event->id],
        ])->exists();

        $isPlayerVisitor = DB::table('player_visitor')->where([
            ['player_id', $value],
            ['event_id', request()->route('result')->event->id],
        ])->exists();

        if ($isPlayerLocal || $isPlayerVisitor) return true;
        
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The player is not in the event.';
    }
}
