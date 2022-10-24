<?php

namespace App\Http\Controllers;

use App\Models\History;

class HistoryController extends Controller
{
    /**
     * Show history
     */
    public function show() {
        $history = History::getList();
        return view('history', [
            'history' => $history
        ]);
    }
}
