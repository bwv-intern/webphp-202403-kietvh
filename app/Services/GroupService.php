<?php

namespace App\Services;

use App\Libs\{CSVUtil, ConfigUtil};
use App\Repositories\GroupRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class GroupService
{
    protected GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository) {
        $this->groupRepository = $groupRepository;
    }

    public function getAll() {
        return $this->groupRepository->getAll();
    }

    public function messages($row, $rowIndex) {
        $messages = [
            'id.numeric' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['ID']),
            'id.digits_between' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['ID']),

            'name.required' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT001', ['Group Name']),
            'name.string' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Group Name']),
            'name.max' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT002', ['Group Name', 255, mb_strlen($row['name'])]),

            'note.string' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Group Note']),

            'group_leader_id.required' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT001', ['Group Leader']),
            'group_leader_id.numeric' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Group Leader']),
            'group_leader_id.digits_between' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Group Leader']),
            'group_leader_id.exists' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT094', ['Group Leader']),

            'group_floor_number.required' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT001', ['Floor Number']),
        ];

        return $messages;
    }

    public function validateRow($row, $rules, $rowIndex) {
        $validator = Validator::make($row, $rules);
        $validator->setCustomMessages($this->messages($row, $rowIndex));
        $validator->after(function ($validator) use ($row, $rowIndex) {
            if ($row['deleted_date'] != '' && $row['deleted_date'] != 'Y') {
                $validator->errors()->add('deleted_date', "Dòng {$rowIndex} :" . ConfigUtil::getMessage('EBT010', ['Delete']));
            }
        });

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        return [];
    }

    public function importCsv($filePath) {
        $csvUtil = new CSVUtil();

        $file = fopen($filePath, 'r');
        $fileYAMLPath = '/app/Constant/Config/configImport.yml';
        $configName = 'group_import_csv_configs';

        $headersYaml = $csvUtil->getHeaderFromConfigsYAML($fileYAMLPath);
        $headersCSV = $csvUtil->getHeaderCSVFile($file);
        $checkHeader = $csvUtil->checkHeader($headersYaml, $headersCSV);
        if (! $checkHeader) {
            fclose($file);

            return [
                'message' => 'WRONG_HEADER',
                'data' => [],
            ];
        }

        $savedGroups = [];
        $editedGroups = [];
        $errorList = [];

        $savedIDEdit = [];

        $rowIndex = 0;

        $keyYaml = $csvUtil->getKeyYaml($fileYAMLPath, $configName);

        $rules = $csvUtil->getValidation($fileYAMLPath, $configName);
        while ($row = fgetcsv($file)) {
            $rowIndex++;

            // Check if the number of fields in the row is different from the number of headerCSV
            if (count($row) != count($headersCSV)) {
                fclose($file);

                return [
                    'message' => 'WRONG_HEADER',
                    'data' => [],
                ];
            }

            $row = array_combine($keyYaml, $row);
            $rules = array_combine($keyYaml, $rules);
            if (in_array($row['id'], $savedIDEdit)) {
                $errorList[] = "Row {$rowIndex} :" . ConfigUtil::getMessage('EBT057', ['ID']);
            }

            // validate row
            $errors = $this->validateRow($row, $rules, $rowIndex);
            if (count($errors) > 0) {
                $errorList[] = $errors;
            } else {
                if ($row['id'] === '') {
                    unset($row['id']);
                    $row['deleted_date'] = "";
                    $savedGroups[] = $row;
                } else {
                    $row['deleted_date'] = Carbon::now()->toDateString();
                    $editedGroups[] = $row;
                    $savedIDEdit[] = $row['id'];
                }
            }
        }
        fclose($file);
        if (count($errorList) > 0) {

            return [
                'message' => 'ERROR',
                'data' => $errorList,
            ];
        }

        if (count($savedGroups) > 0) {
            $this->groupRepository->insertMany($savedGroups);
        }

        if (count($editedGroups) > 0) {
            $this->groupRepository->editMany($editedGroups);
        }

        return [
            'message' => 'SUCCESS',
            'data' => [],
        ];
    }
}
