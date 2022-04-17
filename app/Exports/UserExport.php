<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromArray;

class UserExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    protected $selected;

    public function __construct($selected)
    {   
        $this->selected = $selected;
        // dd($this->selected);
    }

    public function map($user): array
    {
        return
        [
            $user->id,
            $user->name,
            $user->email,
        ];
    }
    
    public function headings(): array
    {


        return[
            ['SUMMARY OF DISBURSEMENT'],
            ['REGION XI'],
            ['ELEMENTARY AND SECONDARY'],
            ['FOR THE MONTH OF MARCH 2022'],
            ['DIVISION ','Bank Account','Number','Absences', '009', '017', '061', '037/216', 'NET', 'Government Share', 'TOTAL', ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:C1')
                                ->getFont()
                                ->setBold(true);
   
            },
        ];
    }

     public function query()
    {
        return User::whereIn('id', $this->selected);
    }

   

    // public function collection()
    // {
    //     return User::all();
    // }
    
}
