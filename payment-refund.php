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
                                    Ödeme İade
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
                        <div class="col-12">
                            <div class="form-group">
                                <label class="col-form-label">Tutar</label>
                                <input type="text" class="form-control" value="100" data-val="true" id="TotalAmount" name="TotalAmount">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <div>
                            <input type="text" name="PaymentType" value="RefundPayment" class="d-none">
                            <button type="submit" class="btn btn-success" name="standart-payment">Ödemeyi Tamamla</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php include 'views/shared/_footer.php'; ?>