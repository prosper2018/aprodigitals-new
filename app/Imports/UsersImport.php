<?php

namespace App\Imports;

use App\Http\Controllers\ThirdPartyApiController;
use App\Models\Bank;
use App\Models\BusinessDetails;
use App\Models\CountryCode;
use App\Models\Department;
use App\Models\Position;
use App\Models\Religion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class UsersImport implements ToCollection, WithStartRow
{
    protected $startRow = 5; // Specify the row number from which the data starts

    private $sheetName;

    protected $ipAddress;

    public function __construct($ipAddress, $sheetName)
    {
        $this->ipAddress = $ipAddress;
        $this->sheetName = $sheetName;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $errors = [];
        try {
            foreach ($collection as $key => $row) {

                $data_row = ($this->startRow + $key);

                $username = isset($row[0]) ? $row[0] : '';
                $firstname = isset($row[1]) ? $row[1] : '';
                $lastname = isset($row[2]) ? $row[2] : '';
                $email = isset($row[3]) ? $row[3] : '';
                $mobile_phone = isset($row[4]) ? $row[4] : '';
                $department_name = isset($row[5]) ? $row[5] : '';
                $position_name = isset($row[6]) ? $row[6] : '';
                $contact_address = isset($row[7]) ? $row[7] : '';
                $gender = isset($row[8]) ? $row[8] : '';
                $dob = isset($row[9]) ? date('Y-m-d', strtotime(str_replace('/', '-', $row[9]))) : '1970-01-01';
                $nationality = isset($row[10]) ? $row[10] : '';
                $marital_status = isset($row[11]) ? $row[11] : '';
                $employment_date = isset($row[12]) ? date('Y-m-d', strtotime(str_replace('/', '-', $row[12]))) : '1970-01-01';
                $termination_date = isset($row[13]) ? date('Y-m-d', strtotime(str_replace('/', '-', $row[13]))) : '1970-01-01';
                $employment_type = isset($row[14]) ? $row[14] : '';
                $business_name = isset($row[15]) ? $row[15] : '';
                $entry_salary = isset($row[16]) ? $row[16] : 0.00;
                $current_salary = isset($row[17]) ? $row[17] : 0.00;
                $current_usd_salary = isset($row[18]) ? $row[18] : 0.00;
                $currency_type = (isset($row[19]) && $row[19] != '') ? $row[17] : 'naira';
                $last_increment = isset($row[20]) ? $row[20] : 0.00;
                $last_increment_date = isset($row[21]) ? date('Y-m-d', strtotime(str_replace('/', '-', $row[21]))) : '1970-01-01';
                $last_promotion_date = isset($row[22]) ? date('Y-m-d', strtotime(str_replace('/', '-', $row[22]))) : '1970-01-01';
                $password = isset($row[23]) ? $row[23] : '';
                $religion = isset($row[24]) ? $row[24] : '';
                $bank_account_no = isset($row[25]) ? $row[25] : '';
                $bank_code = isset($row[26]) ? $row[26] : '';
                $bank_account_name = isset($row[27]) ? $row[27] : $bank_code;

                $posted_ip = $this->ipAddress;
                $posted_user = auth()->user()->username_sess;
                $created = date('Y-m-d H:i:s');

                $user = User::where('username', $username)->first();
                if ($user) {
                    continue; // Skip processing this row
                }

                $data = [
                    'username' => $username,
                    'email' => $email,
                    'dob' => $dob,
                    'contact_address' => $contact_address,
                    'nationality' => $nationality,
                    'marital_status' => $marital_status,
                    'employment_date' => $employment_date,
                    'termination_date' => $termination_date,
                    'employment_type' => $employment_type,
                    'entry_salary' => $entry_salary,
                    'current_salary' => $current_salary,
                    'current_usd_salary' => $current_usd_salary,
                    'last_increment' => $last_increment,
                    'last_increment_date' => $last_increment_date,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'display_name' => $lastname . ' ' . $firstname,
                    'mobile_phone' => $mobile_phone,
                    'passchg_logon' => isset($passchg_logon) ? 1 : 0,
                    'user_locked' => isset($user_locked) ? 1 : 0,
                    'day_1' => 1,
                    'day_2' => 1,
                    'day_3' => 1,
                    'day_4' => 1,
                    'day_5' => 1,
                    'day_6' => 1,
                    'day_7' => 1,
                    // 'staff_id' => $staff_id,
                    'gender' => $gender,
                    'currency_type' => $currency_type,
                    'last_promotion_date' => $last_promotion_date,
                    'posted_ip' => $posted_ip,
                    'posted_user' => $posted_user,
                    'created' => $created,
                    'password' => $password,
                    'department' => $department_name,
                    'position' => $position_name,
                    'business' => $business_name,
                    'bank_account_no' => $bank_account_no,
                    'bank' => $bank_code,
                    'bank_account_name' => $bank_account_name,
                    'religion' => $religion,
                ];

                $validator = Validator::make(
                    $data,
                    [
                        'username' => ['required', 'string', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                        'department' => ['required'],
                        'position' => ['required'],
                        'gender' => ['required'],
                        'dob' => ['required'],
                        'contact_address' => ['required'],
                        'nationality' => ['required'],
                        'religion' => ['required'],
                        'marital_status' => ['required'],
                        'employment_date' => ['required'],
                        'termination_date' => ['required'],
                        'employment_type' => ['required'],
                        'business' => ['required'],
                        'entry_salary' => ['required'],
                        'current_salary' => ['required', 'numeric', 'min:0'],
                        'current_usd_salary' => ['required', 'numeric', 'min:0'],
                        'last_increment' => ['required', 'numeric', 'min:0'],
                        'last_increment_date' => ['required'],
                        'last_promotion_date' => ['required'],
                        'bank_account_no' => ['required', 'numeric'],
                        'bank' => ['required'],
                        'bank_account_name' => ['required'],
                        'firstname' => ['required', 'string', 'max:100'],
                        'lastname' => ['required', 'string', 'max:100'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'mobile_phone' => ['required', 'numeric', 'min:11', 'unique:users'],
                    ]
                );


                if ($validator->fails()) {
                    $allErrors = $validator->errors()->toArray();
                    foreach ($allErrors as $field => $messages) {
                        foreach ($messages as $message) {
                            $errors[] = "Row $data_row:  $message";
                        }
                    }
                    throw ValidationException::withMessages($errors);
                }



                if ($nationality != '') {
                    $nationality_arr =  CountryCode::select(['id'])->where(['country_name' => $nationality])->first();
                    $nationality_id = $nationality_arr ? $nationality_arr->id : null;

                    if ($nationality_id == null) {
                        $errors[] = "Row $data_row:  Nationality [$nationality] on row $data_row not found on the system! Please check your details and try again!";
                    }

                    $data['nationality'] = $nationality_id;
                }

                if ($religion != '') {
                    $religion_arr =  Religion::select(['id'])->where(['display_name' => $religion])->first();
                    $religion_id = $religion_arr ? $religion_arr->id : null;

                    if ($religion_id == null) {
                        $errors[] = "Row $data_row:  Religion [$religion] on row $data_row not found on the system! Please check your details and try again!";
                    }

                    $data['religion'] = $religion_id;
                }


                if ($bank_account_no != '' && $bank_code != '') {
                    $bank_arr =  Bank::select(['bank_code'])->where(['bank_name' => $bank_code])->first();
                    $bank_code_id = $bank_arr ? $bank_arr->bank_code : null;

                    if ($bank_code_id == null) {
                        $errors[] = "Row $data_row:  Bank [$bank_code] on row $data_row not found on the system! Please check your details and try again!";
                    }

                    $thirdparty = new ThirdPartyApiController();
                    $validate = $thirdparty->verifyBankAccountNumber($bank_account_no, $bank_code_id);
                    $code = $validate['response_code'] ?? 20;
                    $message = $validate['response_message'] ?? 'Unable to validate bank account number. Please try again.';
                    if ($code != 0) {
                        $errors[] = "Row $data_row:  $message";
                    }


                    $data['bank_code'] = $bank_code_id;
                    $data['bank_account_name'] = $message;
                }

                $business_arr =  BusinessDetails::select(['id'])->where(['business_name' => $business_name])->first();
                $business_id = $business_arr ? $business_arr->id : null;

                if ($business_id == null) {
                    $errors[] = "Row $data_row:  Business Name [$business_name] on row $data_row not found on the system! Please check your details and try again!";
                }

                $department_arr =  Department::select(['id'])->where(['display_name' => $department_name])->first();
                $department_id = $department_arr ? $department_arr->id : null;

                if ($department_id == null) {
                    $errors[] = "Row $data_row:  Department [$department_name] on row $data_row not found on the system! Please check your details and try again!";
                }

                $position_arr =  Position::select(['position_id', 'department_id'])->where(['position_name' => $position_name, 'department_id' => $department_id])->first();
                $position_id = $position_arr ? $position_arr->position_id : null;
                $position_dept = $position_arr ? $position_arr->department_id : null;

                if ($position_id == null) {
                    $errors[] = "Row $data_row: Position [$position_name] on row $data_row not found on the system! Please check your details and try again!";
                }


                if ($department_id != $position_dept) {
                    $errors[] = "Row $data_row: Postion [$position_name] on row $data_row not found in [$department_name]! Please check your details and try again!";
                }



                if ($employment_type != 'Full Time' && $employment_type != 'Part Time' && $employment_type != 'Contract') {
                    $errors[] = "Row $data_row: Invalid Employment type [' . $employment_type . '] on row $data_row! Please use one of the employment options provided!";
                }

                $data['password'] = Hash::make($password);
                $data['position_id'] = $position_id;
                $data['department_id'] = $department_id;
                $data['business_id'] = $business_id;

                if (!empty($errors)) {
                    throw ValidationException::withMessages($errors);
                }


                User::create($data);
            }
        } catch (ValidationException $ex) {
            $errors = $ex->validator->errors()->toArray();
            throw ValidationException::withMessages($errors);
        }
    }

    public function startRow(): int
    {
        return $this->startRow;
    }

    public function onlySheets(): array
    {
        return [$this->sheetName]; // Specify the sheet name to read
    }

}
