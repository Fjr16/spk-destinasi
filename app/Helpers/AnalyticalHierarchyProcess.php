<?php

namespace App\Helpers;

use App\Models\Criteria;
use Illuminate\Support\Facades\Auth;

class AnalyticalHierarchyProcess
{

    public $criteria;
    public function __construct() {
        $this->criteria = Criteria::query();
    }

    // public function getBobot() {

    // }
    public function generateQuestions() {
        $criteria = $this->criteria->where('is_include', true)->get();

        $matriks = [];
        $residuMatriks = [];
        foreach ($criteria as $item) {
            $matriks[] = $this->generateMatriks($criteria, $item);
            $residuMatriks[] = $this->getResiduMatriks($criteria, $item);
        }

        $filteredM = array_values(array_filter($matriks, function ($item) {
            return !empty($item);
        }));
        $filteredR = array_values(array_filter($residuMatriks, function ($item) {
            return !empty($item);
        }));

        // Flatten array
        $flattenedM = array_merge(...$filteredM);
        $flattenedR = array_merge(...$filteredR);

        $res = [
            'matriks_manual_fill' => $flattenedM,
            'matriks_auto_fill' => $flattenedR,
        ];

        return $res;
    }
    private function generateMatriks($data, $currentCriteria) {
        $matriks = [];

        foreach ($data as $row) {
            $entry = [];


            if ($currentCriteria->id < $row->id) {
                $entry['criteria_id_first'] = $currentCriteria->id;
                $entry['criteria_name_first'] = $currentCriteria->name;
                $entry['criteria_id_second'] = $row->id;
                $entry['criteria_name_second'] = $row->name;
            }else{
                continue;
            }

            $matriks[] = $entry;
        }

        return $matriks;
    }

    private function getResiduMatriks($data, $currentCriteria) {
        $matriks = [];

        foreach ($data as $row) {
            $entry = [];


            if ($currentCriteria->id < $row->id) {
                continue;
            }else if($currentCriteria->id === $row->id){
                $entry['criteria_id_first'] = $currentCriteria->id;
                $entry['criteria_name_first'] = $currentCriteria->name;
                $entry['criteria_id_second'] = $row->id;
                $entry['criteria_name_second'] = $row->name;
                $entry['nilai'] = '1';
            }else{
                $entry['criteria_id_first'] = $currentCriteria->id;
                $entry['criteria_name_first'] = $currentCriteria->name;
                $entry['criteria_id_second'] = $row->id;
                $entry['criteria_name_second'] = $row->name;
                $entry['nilai'] = null;
            }

            $matriks[] = $entry;
        }

        return $matriks;
    }


    public function getSkalaSaaty() {
            $data = [
                [
                    'nilai' => 1,
                    'ket' => 'Sama penting',
                ],
                [
                    'nilai' => 2,
                    'ket' => 'Diantara sama penting dan sedikit lebih penting',
                ],
                [
                    'nilai' => 3,
                    'ket' => 'Sedikit lebih penting',
                ],
                [
                    'nilai' => 4,
                    'ket' => 'Diantara sedikit lebih penting dan lebih penting',
                ],
                [
                    'nilai' => 5,
                    'ket' => 'Lebih penting',
                ],
                [
                    'nilai' => 6,
                    'ket' => 'Diantara lebih penting dan sangat penting',
                ],
                [
                    'nilai' => 7,
                    'ket' => 'Sangat penting',
                ],
                [
                    'nilai' => 8,
                    'ket' => 'Diantara sangat penting dan ekstrem penting',
                ],
                [
                    'nilai' => 9,
                    'ket' => 'Ekstrem penting',
                ],
            ];
        return $data;
    }
}


