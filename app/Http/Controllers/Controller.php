<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiResponse($status,$result){
        $response = "";
        switch ($status) {
            case 200:
                $response = "Success";
                break;
            case 400:
                $response = "Bad Request";
                break;
            case 401:
                $response = "Not Authorized";
                break;
            case 404:
                $response = "Not Found";
                break;
            case 409:
                $response = "User Already Exists";
                break;
            case 500:
                $response = "Internal Server Error";
                break;
            
            default:
            $response = "Unknown Status";
                break;      
        }

        if ($status == 200) {
            return array(
                'timestamp' => Carbon::parse(now())->format("Y-m-d H:i:s"),
                'result' => $result,
                'message' => $response
            );
        }else {
            return array(
                'timestamp' => Carbon::parse(now())->format("Y-m-d H:i:s"),
                'error' => $result,
                'message' => $response
            );
        }
    }
}
