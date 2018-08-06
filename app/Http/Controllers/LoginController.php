<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Logging\Log;

define('CONST_SERVER_TIMEZONE', 'Asia/Taipei');
define('CONST_BUSINESS_CODE', 'MER10001');
define('CONST_SERVER_DOMAIN', 'http://ianus.inin');
define('CONST_PRIVATE_KEY', 'ABCDEFGHIJKLMN12');


class LoginController extends Controller
{
    function randomChar() {
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $seed = str_split($charset);
        shuffle($seed);
        $random = '';
        foreach (array_rand($seed, 6) as $k) $random .= $seed[$k];

        date_default_timezone_set(CONST_SERVER_TIMEZONE);
        $date = substr(date("YmdHis"), 2, 14);

        return  $date . $random;
    }

    function validCode($jsonData = 1) {
        $validCode = md5($jsonData . "-" . CONST_PRIVATE_KEY);

        return $validCode;
    }

    public static function callAPI($method, $url, $query)
    {
        $responses = "call api url error";
        $curl_service = new Client(['base_uri' => CONST_SERVER_DOMAIN]);
//        $headers = ['headers' => ['token' => env("TOKEN"), 'access-token' => "test"]];
        try {
            switch ($method) {
                case "GET":
                    $methodQuery = "query";
                    $response = $curl_service->request($method, $url, [$methodQuery => $query]);
                    $responses = json_decode($response->getBody(), true);
                    break;
                case "POST":
                    $methodQuery = "body";
                    $response = $curl_service->request($method, $url, [$methodQuery => json_encode($query)]);
                    $responses = json_decode($response->getBody(), true);
                    break;
                case "PUT":
                    $methodQuery = "bodybody";
                    $response = $curl_service->request($method, $url, [$methodQuery => json_encode($query)]);
                    $responses = json_decode($response->getBody(), true);
                    break;
                default:
                    echo "method error";
                    return;
            }

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $msg = $e->getMessage() . PHP_EOL;
                $msg .= "Request :" . Psr7\str($e->getRequest()) . PHP_EOL;
                $msg .= "Response :" . Psr7\str($e->getResponse()) . PHP_EOL;
                $responses = array('error' => 'error');

                dd($responses);
                if ( ! is_null($msg)) {
                    \Log::useDailyFiles(storage_path().'/api_error/'. 'api_error');
                    \Log::info('curl error :', ['error msg' => $msg]);
                }
            }
        }

        return $responses;
    }
    //註冊
    function createUser(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        $exists = \DB::table('users')->where('userName', $username)->first();
        if($exists){

            return redirect()->back()->with('message', '使用者重複');
        }

        \DB::table('users')->insert(['userName' => $username, 'password' => $password, 'point' => 0]);

        return redirect('bbin/login');
    }
    //登入
    function login(Request $request) {
        $account = $request->input('account');
        $password = $request->input('password');
        $lang = $request->input('lang');
        //驗證帳號密碼
        $exists = \DB::table('users')
            ->where('userName', $account)
            ->where('password', $password)
            ->first();
        if(!$exists){

            return redirect()->back()->with('message', '帳號密碼錯誤');
        }
        //登入給session
        \Session::put('key',"bbinplatform");
        \Session::put('account', $account);
        \Session::save();
        //需判斷有沒有註冊過遊戲商帳號
//        self::createPaltformUser($request);
        //參數轉換
        $data = array("account" => "$account","lang" => $lang);
        $valid_code = self::validCode(json_encode($data));
        //call api
        $responses = self::callAPI('POST', '/api/login', ['merchant' => CONST_BUSINESS_CODE, 'message_id' => 'U1'.self::randomChar(), 'valid_code' => $valid_code, 'data' => $data]);
        //寫追朔碼 log
        \Log::useDailyFiles(storage_path().'/message_id/'. 'message_id');
        \Log::info('message_id:', ['api' => 'api/login', 'id' => "1234", 'message_id' => "U1" . self::randomChar()]);

        if (empty($responses['success'])) {
            echo "登入失敗！";
            dd($responses);

            return redirect('bbin/login');
        }else {
            //導登入頁
            return redirect()->route('platform');
        }
    }

    //查詢額度頁面
    function platform() {
        //取餘額
        $balance = self::getBalance(session()->all()['account']);
        if (empty($balance['success'])) {

            return view('platform', ['account' => $balance['success'][0]['account'], 'point' => "Nab"]);
        }

        $point = (empty($balance['success'][0]['point'])) ? 0 : $balance['success'][0]['point'];
        return view('platform', ['account' => $balance['success'][0]['account'], 'point' => $point]);
    }

    //登出
    function logout(Request $request) {
        $request->session()->forget('key');
        return redirect('/bbin/login');
    }

    function createPaltformUser(Request $request) {
        $account = $request->input('account');
        $currency = $request->input('currency');
        //參數轉換
        $data = array("account" => $account, "currency" => $currency);
        $valid_code = self::validCode(json_encode($data));
        //call api
        $responses = self::callAPI('POST', '/api/member/create', ['merchant' => CONST_BUSINESS_CODE, 'message_id' => 'U2'.self::randomChar(), 'valid_code' => $valid_code, 'data' => $data]);
        //寫追朔碼 log
        \Log::useDailyFiles(storage_path().'/message_id/'. 'message_id');
        \Log::info('message_id:', ['api' => '/api/member/create', 'id' => "1234", 'message_id' => "U2" . self::randomChar()]);
        var_dump($responses);

        return redirect()->route('platform');
    }

    //搜尋餘額
    function getBalance($account) {
        //先一筆寫死
        $data = array("users" => array($account));
        $balance = self::callAPI('GET', '/api/members/balance', ['merchant' => CONST_BUSINESS_CODE, 'message_id' => 'R2'.self::randomChar(), 'data' => json_encode($data)]);

        //寫追朔碼 log
        \Log::useDailyFiles(storage_path().'/message_id/'. 'message_id');
        \Log::info('message_id:', ['api' => '/api/members/balance', 'id' => "1234", 'message_id' => "R2" . self::randomChar()]);

        return $balance;
    }

    //取得交易約定碼交易約定碼
    function getTransferPointCode() {
        $responses = self::callAPI('GET', '/api/point/prepare', ['merchant' => CONST_BUSINESS_CODE, 'message_id' => 'P1' . self::randomChar()]);
        //寫追朔碼 log
        \Log::useDailyFiles(storage_path().'/message_id/'. 'message_id');
        \Log::info('message_id:', ['api' => '/api/point/prepare', 'id' => "1234", 'message_id' => "P1" . self::randomChar()]);
        if (empty($responses['success'])) {

            return $responses;
        }else {

            return $responses['success'];
        }
    }

    function transferPoint(Request $request) {
        $pinCode = self::getTransferPointCode();
        $account = $request->input('account');
        $action = $request->input('action');
        $point = (int)$request->input('point');
//        if(!preg_match("/^0│[1-9]+(\.[0-9]{0,2})*$/i", $point))
        if($point < 0) {
            return  redirect()->route('platform')->with('message', '輸入金額錯誤');
        }

        $userArr = array(array("account" => $account,"point" => $point));
        $data = array("pin_code" => $pinCode, "users" => $userArr);
        $valid_code = self::validCode(json_encode($data));
        //參數轉換
        switch ($action) {
            case "in":
                try {
                    \DB::connection()->getPdo()->beginTransaction();
                    $user = \DB::table('users')->where('userName', $account)->get();
                    if (($user[0]->point + $point) < 0 ){
                        return  redirect()->route('platform')->with('message', '餘額不足');
                    }
                    $point = $user[0]->point + $point;
                    \DB::table('users')->where('userName', $account)->update(['point' => $point]);
                    \DB::connection()->getPdo()->commit();
                } catch (\PDOException $e) {
                    echo $e;
                    \DB::connection()->getPdo()->rollBack();
                    return  redirect()->route('platform')->with('message', $e);
                }
                break;
            case "transfer":
                try {
                    \DB::connection()->getPdo()->beginTransaction();
                    $user = \DB::table('users')->where('userName', $account)->get();
                    if (($user[0]->point - $point) < 0 ){
                        return  redirect()->route('platform')->with('message', '餘額不足');
                    }
                    $point = $user[0]->point - $point;

                    \DB::table('users')->where('userName', $account)->update(['point' => $point]);
                    \DB::connection()->getPdo()->commit();
                } catch (\PDOException $e) {
                    echo $e;
                    \DB::connection()->getPdo()->rollBack();
                    return  redirect()->route('platform')->with('message', $e);
                }

                $responses = self::callAPI('POST', '/api/point/deposit', ['merchant' => CONST_BUSINESS_CODE, 'message_id' => 'P2' . self::randomChar(), 'valid_code' => $valid_code, 'data' => $data]);
                //寫追朔碼 log
                \Log::useDailyFiles(storage_path().'/message_id/'. 'message_id');
                \Log::info('message_id:', ['api' => '/api/point/deposit', 'id' => "1234", 'message_id' => "P2" . self::randomChar()]);
                if (empty($responses["success"])) {
                    return  redirect()->route('platform')->with('message', 'api操作錯誤');
                }
                break;
            case "out":
                try {
                    \DB::connection()->getPdo()->beginTransaction();
                    $user = \DB::table('users')->where('userName', $account)->get();
                    if (($user[0]->point + $point) < 0 ){
                        return  redirect()->route('platform')->with('message', '餘額不足');
                    }
                    $point = $user[0]->point + $point;
                    \DB::table('users')->where('userName', $account)->update(['point' => $point]);
                    \DB::connection()->getPdo()->commit();
                } catch (\PDOException $e) {
                    \DB::connection()->getPdo()->rollBack();
                    return  redirect()->route('platform')->with('message', $e);
                }

                $responses = self::callAPI('POST', '/api/point/withdrawal', ['merchant' => CONST_BUSINESS_CODE, 'message_id' => 'P3' . self::randomChar(), 'valid_code' => $valid_code, 'data' => $data]);

                //寫追朔碼 log
                \Log::useDailyFiles(storage_path().'/message_id/'. 'message_id');
                \Log::info('message_id:', ['api' => '/api/point/withdrawal', 'id' => "1234", 'message_id' => "P3" . self::randomChar()]);
                if (empty($responses["success"])) {
                    return  redirect()->route('platform')->with('message', 'api操作錯誤');
                }

                break;
            default:
                return  redirect()->route('platform')->with('message', '參數錯誤');
        }

        return  redirect()->route('platform');
    }
}
