<?php


namespace App\Exports\Sheets;


use App\Models\FormSubmission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class FormSubmissionsSheet implements FromCollection, WithMapping, WithTitle, WithHeadings
{
    public $form_submissions;

    public function __construct($form_submissions)
    {
        $this->form_submissions = $form_submissions;
    }

    public function collection()
    {
        return $this->form_submissions;
    }

    /**
     * @var $form_submission
     */
    public function map($form_submission): array
    {
        $map = [
            $form_submission->id
        ];

        $submited_data = $form_submission->data_submited;

        $data = [];
        foreach ($form_submission->form_data as $input_name => $input_label)
        {
            $data[] = array_key_exists($input_name, $submited_data) ? $submited_data[$input_name] : '';
        }

        $map = array_merge($map, $data, [
            $form_submission->locale,
            $form_submission->form_url
        ]);

        return $map;
    }

    public function title(): string
    {
        $min_date = $this->form_submissions->min('created_at')->format('d-m-Y');
        $max_date = $this->form_submissions->max('created_at')->format('d-m-Y');

        return $min_date.'_'.$max_date;
    }

    public function headings(): array
    {
        $headings = [
            '#'
        ];

        $inputs = $this->form_submissions->first()->form_data;

        $headings = array_values(array_merge($headings, $inputs, ['locale', 'url']));

        return $headings;
    }
}
