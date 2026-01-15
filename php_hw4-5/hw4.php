<?php
// ================== รับข้อมูลจากฟอร์ม ==================
$orderInput = $_POST['order_total'] ?? '';
$orderTotal = is_numeric($orderInput) ? (float)$orderInput : 0;
$hasMembership = isset($_POST['vip']);
$alert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_numeric($orderInput) || $orderTotal < 0) {
        $alert = 'ยอดซื้อไม่ถูกต้อง กรุณากรอกตัวเลขที่มากกว่าหรือเท่ากับ 0';
    }
}

// ================== กำหนดค่าพื้นฐาน ==================
$baseDiscount = 0;
$tierName = 'ไม่มีส่วนลด';
$upgradePoint = null;
$upgradeRate = null;

// ================== เงื่อนไขระดับส่วนลด ==================
switch (true) {
    case $orderTotal >= 5000:
        $baseDiscount = 20;
        $tierName = 'Platinum';
        break;
    case $orderTotal >= 3000:
        $baseDiscount = 15;
        $tierName = 'Gold';
        $upgradePoint = 5000;
        $upgradeRate = 20;
        break;
    case $orderTotal >= 1000:
        $baseDiscount = 10;
        $tierName = 'Silver';
        $upgradePoint = 3000;
        $upgradeRate = 15;
        break;
    case $orderTotal >= 500:
        $baseDiscount = 5;
        $tierName = 'Bronze';
        $upgradePoint = 1000;
        $upgradeRate = 10;
        break;
    default:
        $upgradePoint = 500;
        $upgradeRate = 5;
}

// ================== ส่วนลดสมาชิก ==================
$memberBonus = ($hasMembership && $orderTotal >= 500) ? 5 : 0;

// ================== คำนวณผลลัพธ์ ==================
$finalDiscount = $baseDiscount + $memberBonus;
$discountValue = $orderTotal * ($finalDiscount / 100);
$finalPrice = $orderTotal - $discountValue;
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<title>โปรแกรมคำนวณส่วนลด</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h4 class="card-title mb-1">ระบบคำนวณส่วนลดร้านค้า</h4>
                    <p class="text-muted mb-4">
                        กรอกยอดซื้อสินค้าและเลือกสถานะสมาชิก
                    </p>

                    <?php if ($alert): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($alert) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">ยอดซื้อ (บาท)</label>
                            <input type="number"
                                   name="order_total"
                                   step="0.01"
                                   class="form-control"
                                   placeholder="เช่น 2500"
                                   value="<?= htmlspecialchars($orderInput) ?>"
                                   required>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="vip"
                                   id="vip"
                                   <?= $hasMembership ? 'checked' : '' ?>>
                            <label class="form-check-label" for="vip">
                                ลูกค้าสมาชิก (รับเพิ่ม 5% เมื่อยอดไม่ต่ำกว่า 500 บาท)
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            คำนวณราคา
                        </button>
                    </form>

                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$alert): ?>
                        <hr>

                        <h6 class="mb-3">สรุปผลการคำนวณ</h6>

                        <table class="table table-sm">
                            <tr>
                                <td>ระดับลูกค้า</td>
                                <td class="text-end"><?= $tierName ?></td>
                            </tr>
                            <tr>
                                <td>ส่วนลดพื้นฐาน</td>
                                <td class="text-end"><?= $baseDiscount ?>%</td>
                            </tr>
                            <tr>
                                <td>ส่วนลดสมาชิก</td>
                                <td class="text-end"><?= $memberBonus ?>%</td>
                            </tr>
                            <tr>
                                <td>ส่วนลดรวม</td>
                                <td class="text-end"><?= $finalDiscount ?>%</td>
                            </tr>
                            <tr>
                                <td>มูลค่าส่วนลด</td>
                                <td class="text-end">
                                    <?= number_format($discountValue, 2) ?> บาท
                                </td>
                            </tr>
                            <tr class="table-primary">
                                <th>ราคาที่ต้องชำระ</th>
                                <th class="text-end">
                                    <?= number_format($finalPrice, 2) ?> บาท
                                </th>
                            </tr>
                        </table>

                        <?php if ($upgradePoint && $orderTotal < $upgradePoint): ?>
                            <div class="alert alert-info">
                                แนะนำ: ซื้อเพิ่มอีก
                                <strong><?= number_format($upgradePoint - $orderTotal, 2) ?></strong>
                                บาท เพื่อรับส่วนลด <?= $upgradeRate ?>%
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
