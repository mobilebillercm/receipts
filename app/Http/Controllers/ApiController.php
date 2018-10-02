<?php

namespace App\Http\Controllers;

use App\Client;
use App\Domain\GlobalDbRecordCounter;
use App\Domain\GlobalDtoValidator;
use App\Domain\GlobalResultHandler;
use App\Domain\Model\ClientServiceValidity;
use App\Domain\Model\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;


class ApiController extends Controller
{

    public function registerReceiptFromAndroid(){

        $dataJson = file_get_contents('php://input');
        $dataArray =  json_decode($dataJson, true);

        if(!$dataArray){
            return response(GlobalResultHandler::buildFaillureReasonArray("Invalid Data"), 200);
        }



        $validationrules =  [
            'userid' => GlobalDtoValidator::requireStringMinMax(1, 150),
            'tenantid' => GlobalDtoValidator::requireStringMinMax(1, 150),
            'transactionid' => GlobalDtoValidator::requireStringMinMax(1, 500),
            'amount' => GlobalDtoValidator::requireNumeric(),
            'address' => GlobalDtoValidator::requireStringMinMax(1, 1000),
            'date' => GlobalDtoValidator::requireDate(),
            'body' => GlobalDtoValidator::requireStringMinMax(1, 5000),
            'date_sent' => GlobalDtoValidator::requireDate(),
            'current_balance' => GlobalDtoValidator::requireNumeric(),
            'available_balance' => GlobalDtoValidator::requireNumeric(),
            'beneficiary' => GlobalDtoValidator::requireStringMinMax(1, 100),
            'type' => GlobalDtoValidator::requireStringMinMax(1, 100),
            'verification_code' => GlobalDtoValidator::requireStringMinMax(1, 150),

        ];



        if (GlobalDtoValidator::validateData($dataArray, $validationrules)->fails()) {return response(GlobalResultHandler::buildFaillureReasonArray(GlobalDtoValidator::validateData($dataArray, $validationrules)->errors()->first()), 200);}


        $receiptToRegister = new Receipt(
            Uuid::generate()->string,
            $dataArray['userid'],
            $dataArray['tenantid'],
            $dataArray['transactionid'],
            $dataArray['amount'],
            $dataArray['address'],
            $dataArray['date'],
            $dataArray['body'],
            $dataArray['date_sent'],
            $dataArray['current_balance'],
            $dataArray['available_balance'],
            $dataArray['beneficiary'],
            $dataArray['type'],
            $dataArray['verification_code']
        );



        DB::beginTransaction();

        try{

            $receiptToRegister->save();

        }catch (\Exception $e){

            DB::rollBack();


            return response(GlobalResultHandler::buildFaillureReasonArray($e->getMessage()), 200);


            return response(GlobalResultHandler::buildFaillureReasonArray('Unable to register Receipt'), 200);

        }

        DB::commit();

        return response(GlobalResultHandler::buildSuccesResponseArray('Receipt registered Successfully'), 200);

    }


}
