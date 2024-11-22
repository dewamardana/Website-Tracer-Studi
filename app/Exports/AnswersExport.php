<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AnswersExport implements FromView
{
    protected $fetchAnswer;

    public function __construct($fetchAnswer)
    {
        $this->fetchAnswer = $fetchAnswer;
    }

    public function view(): View
    {
        return view('exports.answers', [
            'fetchAnswer' => $this->fetchAnswer
        ]);
    }
}
