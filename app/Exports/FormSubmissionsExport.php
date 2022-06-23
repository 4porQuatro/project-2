<?php

namespace App\Exports;

use App\Exports\Sheets\FormSubmissionsSheet;
use App\Models\FormSubmission;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FormSubmissionsExport implements WithMultipleSheets
{
    protected $form_submissions;

    public function __construct($form_submissions)
    {
        $this->form_submissions = $form_submissions;
    }

    public function sheets(): array
    {
        $sheets = [];

        $form_submissions_groups = $this->form_submissions->groupBy(function ($item){
            return json_encode($item['form_data']) . json_encode('input_types');
        });

        foreach ($form_submissions_groups as $key=>$group)
        {
            $sheets[] = new FormSubmissionsSheet($group);
        }

        return $sheets;
    }
}
