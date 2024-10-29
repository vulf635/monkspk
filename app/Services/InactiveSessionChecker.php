<?php
namespace App\Services;

class InactiveSessionChecker
{
    protected  $table;
    public function __construct()
    {
        $this->table = DB::table('mnk_access');
    }

    public function deleteElementsInactiveByHour(): void
    {
        $inactiveSessions = $this->table->where('created_at', '<', now()->subHour())->get();
    }
}
