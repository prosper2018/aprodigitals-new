<?php

namespace App\Http\Controllers;
use App\Models\Parameter;
use Illuminate\Http\Request;

class ThirdPartyApiController extends Controller
{
    public $bank_verify_url;
    public $bank_verify_secrete_key;
    public function __construct()
    {
        $url_query = Parameter::select('parameter_value')->where(['parameter_name' => 'pay_stack_account_verify'])->first();
        $this->bank_verify_url = $url_query->parameter_value;

        $secre_query = Parameter::select('parameter_value')->where(['parameter_name' => 'paystack_secret_code'])->first();
        $this->bank_verify_secrete_key = $secre_query->parameter_value;

    }

    public function verifyBankAccountNumber($account_number, $bank_code)
    {
        $url_query = Parameter::select('parameter_value')->where(['parameter_name' => 'pay_stack_account_verify'])->first();
        $this->bank_verify_url = $url_query->parameter_value;

        $secre_query = Parameter::select('parameter_value')->where(['parameter_name' => 'paystack_secret_code'])->first();
        $this->bank_verify_secrete_key = $secre_query->parameter_value;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->bank_verify_url . "?account_number=" . $account_number . "&bank_code=" . $bank_code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $this->bank_verify_secrete_key,
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return array('response_code' => 20, 'response_message' => "cURL Error #:" . $err);
        } else {

            $data = json_decode($response, true);
            $data['message'] = (isset($data['message']) && !empty($data['message'])) ? $data['message'] : "Something went wrong!!! Please try again.";

            $message = (isset($data['data']['account_name']) && !empty($data['data']['account_name'])) ? $data['data']['account_name'] : $data['message'];
            $code = (isset($data['data']['account_name']) && !empty($data['data']['account_name'])) ? 0 : 20;
            return array('response_code' => $code, 'response_message' => $message);
        }
    }
}
