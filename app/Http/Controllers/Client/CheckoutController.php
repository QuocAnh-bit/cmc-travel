<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);

        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);



        $result = curl_exec($ch);

        if ($result === false) {
            dd([
                'error' => curl_error($ch),
                'errno' => curl_errno($ch)
            ]);
        }

        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request)
    {
        if ($_POST['booking_status'] !== 'pending' || $_POST['expires_at'] < now()) {
            return back()->with('error', 'Đơn đã hết hạn giữ chỗ');
        }
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua ATM MoMo";
        $amount = $_POST['total_momo'];
        $orderId = 'BK_' . $_POST['booking_id'] . '_' . time();;
        $redirectUrl = ENV("APP_URL") . "checkout";
        $ipnUrl = ENV("APP_URL") . "checkout";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        $extraData = $_POST['booking_id'];
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl']);

        header('Location: ' . $jsonResult['payUrl']);
    }




    public function return(Request $request)
    {
        $data = $request->all();

        $bookingId = $data['extraData'] ?? null;

        print_r($data);
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return back()->with('error', 'Không tìm thấy booking');
        }

        // 🚨 nếu đã confirmed thì thôi
        if ($booking->booking_status === 'confirmed') {
            return redirect()->route('checkout')->with('success', 'Đã thanh toán rồi');
        }


        // ===== SUCCESS =====
        if ($data['resultCode'] == 0) {

            // tránh tạo trùng order
            $existingOrder = Order::where('id', $data['orderId'])->first();

            if (!$existingOrder) {
                Order::create([
                    'user_id' => $booking->user_id,
                    'booking_id' => $bookingId,
                    'order_id' => $data['orderId'],
                    'amount' => $data['amount'],
                    'status' => 'paid',
                    'transaction_id' => $data['transId'],
                    'payment_method' => 'momo',
                    'paid_at' => now(),
                ]);
            }

            $booking->update([
                'status' => 'confirmed'
            ]);

            return  redirect()->to('bookings/' . $bookingId)->with('success', 'Thanh toán thành công');
        }

        // ===== FAIL =====
        $booking->update([
            'status' => 'cancelled'
        ]);

        return redirect()->to('bookings/' . $bookingId)->with('error', 'Thanh toán thất bại');
    }
}
