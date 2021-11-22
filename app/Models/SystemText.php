<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SystemText extends Model
{
      protected $table = 'system_texts';
    protected $fillable = [
        'id',
        'name',
        'title',
        'text',
        'department',
        'type',
        'status',
    ];
    protected $hidden = [
    ];

    
    // MÉTODOS PÚBLICO

    public static function filterSystemTexts(Request $request) {
        $systemTexts = SystemText::where(function ($query) use ($request) {
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->department) {
                        $query->where('department', $request->department);
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->status) {
                        $query->where('status', $request->status);
                    }
                })
                ->orderBy('name', 'ASC')
                ->paginate(20);

        $systemTexts->appends([
            'name' => $request->name,
            'department' => $request->department,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return $systemTexts;
    }
    
        public static function returnStatus() {
            return $status = [
                'ativada',
                'desativada',
            ];
        }
        
        
    public static function returnTypes() {
        return $status = array(
            'primeiros passos',
            'tutorial',
        );
    }
}
