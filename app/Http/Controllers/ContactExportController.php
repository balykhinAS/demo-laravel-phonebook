<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ContactExportController extends Controller
{
    /**
     * @param Request $request
     * @param $format
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function run(Request $request, $format)
    {
        if (!in_array($format, ['xls', 'xlsx', 'csv', 'pdf'])) {
            abort(404);
        }

        $contacts = Contact::query()->find($request->get('select', []))->map(function (Contact $contact) {
            return [
                $contact->first_name,
                $contact->last_name,
                $contact->middle_name,
                $contact->phone,
            ];
        })->toArray();

        return $this->getResponse($contacts, $format);
    }

    /**
     * @param array $contacts
     * @param string $format
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getResponse(array $contacts, string $format)
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->fromArray($contacts);

        $callback = call_user_func([$this, $format], $spreadsheet);

        return response()->streamDownload($callback, Carbon::now()->timestamp . '.' . $format, [
            'Content-type' => 'application/' . $format,
        ]);
    }

    /**
     * @param $spreadsheet
     * @return \Closure
     */
    protected function pdf($spreadsheet)
    {
        return function () use ($spreadsheet) {
            $writer = new Dompdf($spreadsheet);
            $writer->save("php://output");
        };
    }

    /**
     * @param $spreadsheet
     * @return \Closure
     */
    protected function xls($spreadsheet)
    {
        return function () use ($spreadsheet) {
            $writer = new Xls($spreadsheet);
            $writer->save("php://output");
        };
    }

    /**
     * @param $spreadsheet
     * @return \Closure
     */
    protected function xlsx($spreadsheet)
    {
        return function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        };
    }

    /**
     * @param $spreadsheet
     * @return \Closure
     */
    protected function csv($spreadsheet)
    {
        return function () use ($spreadsheet) {
            $writer = new Csv($spreadsheet);
            $writer->save("php://output");
        };
    }
}
