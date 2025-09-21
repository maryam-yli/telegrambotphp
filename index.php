<?php
// PHP Webhook Test Script
// @Mmmmmamad

ob_start();

// 1. توکن ربات خود را اینجا وارد کنید
$API_KEY = '7725428811:AAGLAzYnkkLSiKPpIo0IsFz5Z3UDCsBsO0w'; 
define('API_KEY',$API_KEY);

// دریافت اطلاعات ارسالی از تلگرام
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$name = $message->from->first_name;

// تابع اصلی ارتباط با API تلگرام
function bot($method,$datas=[]){
	$url = "https://api.telegram.org/bot".API_KEY."/".$method;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
	$res = curl_exec($ch);
	if(curl_error($ch)){
		// اگر cURL خطا داد، اینجا در لاگ سرور ثبت می‌شود
		error_log(curl_error($ch));
	}else{
		return json_decode($res);
	}
}

// اگر پیامی دریافت شد:
if(isset($chat_id)){
    $response_text = "سلام $name عزیز!
    ✅ ربات با موفقیت روی هاست InfinityFree فعال است.
    
    شما دستور: $text را ارسال کردید.
    حالا می‌توانیم سراغ کد عضویت اجباری برویم.";

    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>$response_text,
        'parse_mode'=>'html'
    ]);
}

// جلوگیری از ثبت لاگ‌های اضافی
unlink ("error_log");
?>