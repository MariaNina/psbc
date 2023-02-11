<?php


namespace App\Utilities;

use App\Models\AuditTrailTbl;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class AuditTrail
{
    public static function logAuditTrail($action_taken, $description, $new_data = null, $old_data = null)
    {
        $user_id = session('user')->id;
        
        $audit = new AuditTrailTbl();

        $audit->action_taken = $action_taken;
        $audit->description = $description;
        $audit->new_data = $new_data;
        $audit->old_data = $old_data;
        $audit->url = URL::full();
        $audit->ip = Request::ip();
        $audit->user_id = $user_id;
        $audit->datetime = NOW();
        $audit->save();
    }
    
}
