<?php include 'views/shared/_header.php';
require_once('core/entity/CreditCard.php');
require_once('core/entity/Address.php');
require_once('core/entity/OrderItem.php');
require_once('core/entity/Recurring.php');
require_once('core/entity/RecurringPayment.php');
require_once('core/entity/OrderComment.php');
require_once('core/entity/RewardInfo.php');
require_once('core/GarantiPaymentProcess.php');
require_once('core/enums/AddressType.php');
require_once('core/enums/RewardType.php');
require_once('core/helpers/PriceFormatter.php');

use Gosas\Core\Entity\CreditCard;
use Gosas\Core\GarantiPaymentProcess;
use Gosas\Core\Entity\Address;
use Gosas\Core\Entity\OrderComment;
use Gosas\Core\Enums\AddressType;
use Gosas\Core\Entity\OrderItem;
use Gosas\Core\Entity\Recurring;
use Gosas\Core\Entity\RecurringPayment;
use Gosas\Core\Enums\RewardType;
use Gosas\Core\Helpers\PriceFormatter;

?>
<div class="card border-0">
    <div class="card-body">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cardHolderName = $_POST['CardHolderName'];
            $cardNumber = $_POST['CardNumber'];
            $expireMonth = $_POST['ExpireMonth'];
            $expireYear = $_POST['ExpireYear'];
            $cvvCode = $_POST['CvvCode'];
            $totalAmount = PriceFormatter::FormatAmount((float)$_POST['TotalAmount']);
            $paymentType = $_POST['PaymentType'];

            $cardInfo = new CreditCard(
                $cardNumber,
                $cardHolderName,
                $expireYear,
                $expireMonth,
                $cvvCode
            );

            $paymentProcess = new GarantiPaymentProcess();

            switch ($paymentType) {
                case "Payment": {
                        print "Ödeme başladı </br>";
                        $postData = $paymentProcess->PreparePayment($cardInfo, $totalAmount);
                        $response = $paymentProcess->Pay($postData);

                        print "Bankadan Dönen Sonuc: </br>" . json_encode($response);
                        break;
                    }
                case "PreAuth": {
                        print "Ön Otorizasyon Başladı</br>";
                        $postData = $paymentProcess->PreparePreAuthPayment($cardInfo, $totalAmount);
                        $response = $paymentProcess->Pay($postData);

                        print "Bankadan Dönen Sonuc: </br>" . json_encode($response);
                        break;
                    }
                case "PostAuth": {
                        print "Ön Otorizasyon Kapama Başladı</br>";
                        //PostAuth yapılabilmesi için önce Preauth yapıyoruz.
                        $preAuthPostData = $paymentProcess->PreparePreAuthPayment($cardInfo, $totalAmount);
                        $preAuthResponse = $paymentProcess->Pay($preAuthPostData);

                        print "Ön Otorizasyyon:Bankadan Dönen Sonuc: </br>" . json_encode($preAuthResponse) . "</br>";

                        $orderId = $preAuthResponse->Order->OrderID;
                        print "Ön Otorizasyon OrderID: " . $orderId . "</br>";

                        $postData = $paymentProcess->PreparePostAuthPayment($totalAmount, $orderId);
                        $response = $paymentProcess->Pay($postData);

                        print "Bankadan Dönen Sonuc: </br>" . json_encode($response);
                        break;
                    }
                case "CancelPayment": {

                        $paymentPostData = $paymentProcess->PreparePayment($cardInfo, $totalAmount);
                        $paymentResponse = $paymentProcess->Pay($paymentPostData);

                        $orderId = $paymentResponse->Order->OrderID;
                        $retRefNum = $paymentResponse->Transaction->RetrefNum;

                        print "Ödeme iptal başladı </br>";
                        $paymentCancelPostData = $paymentProcess->PrepareCancelPayment($totalAmount, $orderId, $retRefNum);
                        $response = $paymentProcess->Cancel($paymentCancelPostData);

                        print "Bankadan Dönen Sonuc: </br>" . json_encode($response);
                        break;
                    }
                case "RefundPayment": {

                        $paymentPostData = $paymentProcess->PreparePayment($cardInfo, $totalAmount);
                        $paymentResponse = $paymentProcess->Pay($paymentPostData);

                        $orderId = $paymentResponse->Order->OrderID;

                        print "Ödeme iade başladı </br>";
                        $paymentRefundPostData = $paymentProcess->PrepareRefundPayment($totalAmount, $orderId);
                        $response = $paymentProcess->Refund($paymentRefundPostData);

                        print "Bankadan Dönen Sonuc: </br>" . json_encode($response);
                        break;
                    }
                case "PartialRefundPayment": {

                        $paymentPostData = $paymentProcess->PreparePayment($cardInfo, $totalAmount);
                        $paymentResponse = $paymentProcess->Pay($paymentPostData);

                        $orderId = $paymentResponse->Order->OrderID;

                        print "Ödeme kısmi iade başladı </br>";
                        $paymentRefundPostData = $paymentProcess->PrepareRefundPayment($totalAmount - 10, $orderId);
                        $response = $paymentProcess->Refund($paymentRefundPostData);

                        print "Bankadan Dönen Sonuc: </br>" . json_encode($response);
                        break;
                    }
                case "PaymentFull": {
                        $installmentCount = $_POST['InstallmentCount'];
                        print "Ödeme başladı. Taksit sayısı:" . $installmentCount . "</br>";
                        $address = new Address(
                            $_POST['FirstName'],
                            $_POST['LastName'],
                            AddressType::ShippingAddress,
                            $_POST['AddressText'],
                            $_POST['District'],
                            $_POST['City'],
                            $_POST['PhoneNumber']
                        );
                        $orderItem = new OrderItem(
                            $_POST['ItemNumber'],
                            $_POST['ItemProductId'],
                            $_POST['ItemProductCode'],
                            $_POST['ItemQuantity'],
                            PriceFormatter::FormatAmount((float)$_POST['ItemPrice'])
                        );
                        $orderComment = new OrderComment(
                            $_POST['CommentNumber'],
                            $_POST['CommentText']
                        );
                        $postData = $paymentProcess->PreparePaymentWithOrderComment(
                            $cardInfo,
                            $address,
                            $orderItem,
                            $orderComment,
                            $totalAmount,
                            $installmentCount
                        );
                        $response = $paymentProcess->Pay($postData);
                        $orderId = $response->Order->OrderID;
                        print "Bankadan Dönen Sonuc: </br>" . json_encode($response); //get order number
                        break;
                    }
                case "OrderInquiry": {
                        print "Sipariş sorgulama başladı.. </br>";
                        $inquiryPostData = $paymentProcess->PrepareOrderInquiryPayment($cardInfo, $totalAmount, 0);
                        $inquiryResponse = $paymentProcess->Send($inquiryPostData);
                        print "Bankadan Dönen Sonuc: </br>" . json_encode($inquiryResponse);
                        break;
                    }
                case "OrderDetailInquiry": {
                        print "Sipariş detay sorgulama başladı.. </br>";
                        $inquiryPostData = $paymentProcess->PrepareOrderDetailInquiryPayment($cardInfo, $totalAmount, 0);
                        $inquiryResponse = $paymentProcess->Send($inquiryPostData);
                        print "Bankadan Dönen Sonuc: </br>" . json_encode($inquiryResponse);
                        break;
                    }
                case "DateRangeInquiry": {
                        print "Sipariş listesi sorgulama başladı.. </br>";
                        $inquiryPostData = $paymentProcess->PrepareDateRangeInquiryPayment($cardInfo, $totalAmount, 0, "2022/06/01 00:00", "2022/06/15 23:59");
                        $inquiryResponse = $paymentProcess->Send($inquiryPostData);
                        print "Bankadan Dönen Sonuc: </br>" . json_encode($inquiryResponse);
                        break;
                    }
                case "BonusInquiry": {
                        print "Bonus sorgulama başladı.. </br>";
                        $inquiryPostData = $paymentProcess->PrepareBonusInquiryPayment($cardInfo, $totalAmount, 0);
                        $inquiryResponse = $paymentProcess->Send($inquiryPostData);
                        print "Bankadan Dönen Sonuc: </br>" . json_encode($inquiryResponse);
                        break;
                    }
                case "DCCPayment": {
                        print "DCC payment başladı.. </br>";
                        $paymentPostData = $paymentProcess->PrepareDCCPayment($cardInfo, $totalAmount, 0);
                        $paymentResponse = $paymentProcess->Send($paymentPostData);
                        print "Bankadan Dönen Sonuc: </br>" . json_encode($paymentResponse);
                        break;
                    }
                case "PartialCancel": {
                        print "Ön Otorizasyon Kapama Başladı</br>";
                        //PostAuth yapılabilmesi için önce Preauth yapıyoruz.
                        $preAuthPostData = $paymentProcess->PreparePreAuthPayment($cardInfo, $totalAmount);
                        $preAuthResponse = $paymentProcess->Pay($preAuthPostData);

                        print "Ön Otorizasyyon:Bankadan Dönen Sonuc: </br>" . json_encode($preAuthResponse) . "</br>";

                        $orderId = $preAuthResponse->Order->OrderID;
                        print "Ön Otorizasyon OrderID: " . $orderId . "</br>";
                        $retRefNum = $preAuthResponse->Transaction->RetrefNum;
                        print "Ön Otorizasyon OriginalRetrefNum: " . $retRefNum . "</br>";

                        print "Kısmi iptal işlemi başladı.. </br>";
                        $postData = $paymentProcess->PreparePartialCancelPayment($totalAmount - 10, $orderId, $retRefNum);
                        $response = $paymentProcess->Pay($postData);

                        print "Bankadan Dönen Sonuc: </br>" . json_encode($response);
                        break;
                    }
                case "FixedRecurringPayment": {
                        $type = "R";
                        $totalPaymentNum = 5;
                        $ferequencyType = "M";
                        $frequencyInterval = 1;
                        $startDate = "20220801";

                        $recurring = new Recurring(
                            $type,
                            $totalPaymentNum,
                            $ferequencyType,
                            $frequencyInterval,
                            $startDate
                        );

                        print "Fixed recurring payment başladı.. </br>";
                        $paymentPostData = $paymentProcess->PrepareFixedRecurringPayment($cardInfo, $totalAmount, 0, $recurring);
                        $paymentResponse = $paymentProcess->Send($paymentPostData);
                        print "Bankadan Dönen Sonuc: </br>" . json_encode($paymentResponse);
                        break;
                    }
                case "VariableRecurringPayment": {
                        $type = "R";
                        $totalPaymentNum = 2;
                        $ferequencyType = "M";
                        $frequencyInterval = 1;
                        $startDate = "20220801";

                        $recurring = new Recurring(
                            $type,
                            $totalPaymentNum,
                            $ferequencyType,
                            $frequencyInterval,
                            $startDate
                        );

                        $recurringPaymentList = array(
                            new RecurringPayment(
                                900,
                                1
                            ),
                            new RecurringPayment(
                                10,
                                2
                            ),
                        );

                        print "Variable recurring payment başladı.. </br>";
                        $paymentPostData = $paymentProcess->PrepareVariableRecurringPayment($cardInfo, $totalAmount, 0, $recurring, $recurringPaymentList);
                        $paymentResponse = $paymentProcess->Send($paymentPostData);
                        print "Bankadan Dönen Sonuc: </br>" . json_encode($paymentResponse);
                        break;
                    }
                default:
                    print "payment type seçiniz.";
                    break;
            }
        }

        ?>
    </div>
</div>
<?php include 'views/shared/_footer.php'; ?>