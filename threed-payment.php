<?php include 'views/shared/_header.php';

use Gosas\Core\Entity\ThreeDPayment;
use Gosas\Core\GarantiPaymentProcess;
use Gosas\Core\Settings\PosSettings;
use Gosas\Core\Enums\RequestMode;

require_once('core/settings/PosSettings.php');
require_once('core/enums/RequestMode.php');
require_once('core/entity/ThreeDPayment.php');
require_once('core/GarantiPaymentProcess.php');

$settings = new PosSettings(RequestMode::Test);
$paymentProcess = new GarantiPaymentProcess();
$params = new ThreeDPayment();
$paymentProcess->PrepareOrder();
$paymentProcess->PrepareCustomer();




$params = $paymentProcess->PrepareThreeDPayment($paymentProcess->request->order->orderId, 100, 949, 1, 'sales');



$terminalId = "30691297";
$orderId = rand(100000, 999999);
$amount = "111.00";
$currencyCode = "949";
$successUrl = "https://garantibbvapos.com.tr/destek/postback.aspx";
$errorUrl = "https://garantibbvapos.com.tr/destek/postback.aspx";
$type = "sales";
$installmentCount = "";
$storeKey = "12345678";
$provisionPassword = "123qweASD/";

$hashedPassword = sha1($provisionPassword . "0" . $terminalId);
$hashedPassword = strtoupper($hashedPassword);

$secure3dhash_input = $terminalId . $orderId . $amount . $currencyCode . $successUrl . $errorUrl . $type . $installmentCount . $storeKey . $hashedPassword;

$secure3dhash = hash('sha512', $secure3dhash_input);
$secure3dhash = strtoupper($secure3dhash);


?>





<div class="card">
    <div class="card-body">
        <form id="form2" name="form2" method="post" action="https://sanalposprovtest.garantibbva.com.tr/servlet/gt3dengine">

            <div>

                <input type="hidden" name="secure3dsecuritylevel" id="secure3dsecuritylevel" Value="3D_PAY" />

                <input type="hidden" name="mode" id="mode" Value="TEST" />

                <input type="hidden" name="apiversion" id="apiversion" Value="512" />

                <input type="hidden" name="terminalprovuserid" id="terminalprovuserid" Value="PROVAUT" />

                <input type="hidden" name="terminaluserid" id="terminaluserid" Value="SANALUSER" />

                <input type="hidden" name="terminalmerchantid" id="terminalmerchantid" Value="7000679" />

                <input type="hidden" name="txntype" id="txntype" Value="<?php echo $type; ?>" />

                <input type="hidden" name="txnamount" id="txnamount" Value="<?php echo $amount; ?>" />

                <input type="hidden" name="txncurrencycode" id="txncurrencycode" Value="<?php echo $currencyCode; ?>" />

                <input type="hidden" name="txninstallmentcount" id="txninstallmentcount" Value="" />

                <input type="hidden" name="customeremailaddress" id="customeremailaddress" Value="eticaret@garanti.com.tr" />

                <input type="hidden" name="customeripaddress" id="customeripaddress" Value="10.170.3.131" />

                <input type="hidden" name="orderid" id="orderid" Value="<?php echo $orderId; ?>" />

                <input type="hidden" name="terminalid" id="terminalid" Value="<?php echo $terminalId; ?>" />

                <input type="hidden" name="successurl" id="successurl" Value="https://garantibbvapos.com.tr/destek/postback.aspx" />

                <input type="hidden" name="errorurl" id="errorurl" Value="https://garantibbvapos.com.tr/destek/postback.aspx" />


                <input type="hidden" name="lang" id="lang" Value="tr" />

                <input type="hidden" name="secure3dhash" id="secure3dhash" Value="<?php echo $secure3dhash; ?>" />

                <input type="hidden" name="txntimestamp" id="txntimestamp" Value="12/03/2024 16:19:01" />

                <input type="hidden" name="refreshtime" id="refreshtime" Value="5" />
                <input type="hidden" name="puani" id="puani" Value="" />


                <!----Görünün kısmı---->




                <input type="text" name="companyname" id="companyname" Value="GARANTI TEST"  class="form-control" />

                <input type="text" name="cardnumber" id="cardnumber" Value="5406697543211173" class="form-control" />

                <input type="text" name="cardexpiredatemonth" id="cardexpiredatemonth" Value="04"  class="form-control" />

                <input type="text" name="cardexpiredateyear" id="cardexpiredateyear" Value="27" class="form-control" />

                <input type="text" name="cardcvv2" id="cardcvv2" Value=""  class="form-control" />


            </div>

            <!--- Ödenecek tutar ve ödeme butonu---->

            <div class="footer">
                <button type="submit" class="btn btn-primary">Ödeme Yap <?php echo $amount; ?> TL</button>
            </div>
            

        </form>
    </div>
</div>


<style>
    /***Formu Ödeme Sayfası icin uygun tasarım hale getirildi idlere özel işlem yapıldı */


    #form2 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    #form2 input {
        margin: 10px;
        padding: 10px;
        width: 300px;
    }

    #form2 button {
        margin: 10px;
        padding: 10px;
        width: 426px !important;
    }

    .card {
        margin: 10px;
        padding: 10px;
        width: 500px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .footer {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>

<?php include 'views/shared/_footer.php'; ?>
