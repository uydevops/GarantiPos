<?php include 'views/shared/_header.php'; ?>
<div class="card border-0">
    <div class="card-body">
        <form method="POST" action="paymentprocess.php">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div class="card-wrapper">
                                <h3>
                                    Standart Ödeme Full -> Sipariş Bilgileri, Taksit, Yorum, Adres Bilgileri
                                    </h2>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 d-flex">
                        <div class="col-12 panel-title">
                            <h4>Kart Bilgileri</h4>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Kart Üzerindeki Ad Soyad</label>
                                <input class="form-control" value="Test User" type="text" id="CardHolderName" name="CardHolderName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Kart Numarası</label>
                                <input class="form-control" value="5406697543211173" type="text" id="CardNumber" name="CardNumber">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Son Kullanma (Ay)</label>
                                <input class="form-control" value="03" type="number" data-val="true" id="ExpireMonth" name="ExpireMonth">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Son Kullanma (Yıl)</label>
                                <input class="form-control" value="23" type="number" data-val="true" id="ExpireYear" name="ExpireYear">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>CVV2</label>
                                <input class="form-control" value="465" type="text" id="CvvCode" name="CvvCode">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">Tutar</label>
                                <input type="text" class="form-control" value="100" data-val="true" id="TotalAmount" name="TotalAmount">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">Taksit</label>
                                <input type="number" class="form-control" value="3" data-val="true" id="InstallmentCount" name="InstallmentCount">
                            </div>
                        </div>
                        <div class="col-12 panel-title">
                            <h4>Sipariş Bilgileri</h4>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Sipariş No</label>
                                <input class="form-control" value="1001" type="number" id="ItemNumber" name="ItemNumber">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Ürün ID</label>
                                <input class="form-control" value="1001S" type="text" id="ItemProductId" name="ItemProductId">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Ürün Kodu</label>
                                <input class="form-control" value="100S" type="text" id="ItemProductCode" name="ItemProductCode">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Ürün Adedi</label>
                                <input class="form-control" value="2" type="number" id="ItemQuantity" name="ItemQuantity">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Ürün Fiyatı</label>
                                <input class="form-control" value="50" type="number" id="ItemPrice" name="ItemPrice">
                            </div>
                        </div>
                        <div class="col-12 panel-title">
                            <h4>Adres Bilgileri</h4>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Ad</label>
                                <input class="form-control" value="Murat" type="text" id="FirstName" name="FirstName">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Soyad</label>
                                <input class="form-control" value="Öngen" type="text" id="LastName" name="LastName">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Adres</label>
                                <input class="form-control" value="Kirazpınar Mh. 1111 Sk. No:1 D:1" type="text" id="AddressText" name="AddressText">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Telefon</label>
                                <input class="form-control" value="5538037841" type="text" id="PhoneNumber" name="PhoneNumber">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>İl</label>
                                <input class="form-control" value="Kocaeli" type="text" id="City" name="City">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>İlçe</label>
                                <input class="form-control" value="Gebze" type="text" id="District" name="District">
                            </div>
                        </div>
                        <div class="col-12 panel-title">
                            <h4>Sipariş Bilgileri</h4>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Yorum No</label>
                                <input class="form-control" value="1" type="number" id="CommentNumber" name="CommentNumber">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label>Yorum Açıklaması</label>
                                <input class="form-control" value="Özel açıklama alanı" type="text" id="CommentText" name="CommentText">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <div>
                            <input type="text" name="PaymentType" value="PaymentFull" class="d-none">
                            <button type="submit" class="btn btn-success" name="standart-payment">Ödemeyi Tamamla</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php include 'views/shared/_footer.php'; ?>