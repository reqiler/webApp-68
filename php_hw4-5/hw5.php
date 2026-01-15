<?php
// ================== ฟังก์ชันแยกชื่อภาษาไทย ==================
function parseThaiFullname(string $rawFullname): array
{
    $titleCatalog = [
        "เด็กหญิง",
        "เด็กชาย",
        "นางสาว",
        "นาย",
        "นาง",
        "น.ส.",
        "ด.ช.",
        "ด.ญ.",
        "ร.ต.ต.",
        "ด.ต.",
        "มรว.",
        "ผศ.",
        "ดร."
    ];

    $parsedName = [
        'title' => '',
        'given' => '',
        'family' => ''
    ];

    $rawFullname = trim(preg_replace('/\s+/', ' ', $rawFullname));

    usort($titleCatalog, fn($a, $b) =>
        mb_strlen($b, 'UTF-8') <=> mb_strlen($a, 'UTF-8')
    );

    foreach ($titleCatalog as $title) {
        $len = mb_strlen($title, 'UTF-8');
        if (mb_substr($rawFullname, 0, $len, 'UTF-8') === $title) {
            $parsedName['title'] = $title;
            $rawFullname = ltrim(mb_substr($rawFullname, $len, null, 'UTF-8'));
            break;
        }
    }

    $parts = explode(' ', $rawFullname);

    if (count($parts) === 1) {
        $parsedName['given'] = $parts[0];
        return $parsedName;
    }

    $parsedName['given'] = array_shift($parts);
    $parsedName['family'] = implode(' ', $parts);

    return $parsedName;
}

// ================== รับค่าจากฟอร์ม ==================
$result = ['title' => '', 'given' => '', 'family' => ''];

if (!empty($_POST['fullname'])) {
    $result = parseThaiFullname($_POST['fullname']);
}
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>โปรแกรมแยกชื่อ-สกุล</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h4 class="card-title mb-1">
                        โปรแกรมแยกคำนำหน้า ชื่อ และนามสกุล
                    </h4>
                    <p class="text-muted mb-4">
                        รองรับคำนำหน้าแบบเต็ม แบบย่อ และนามสกุลที่มีช่องว่าง
                    </p>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">
                                ชื่อ–นามสกุล (รวมคำนำหน้า)
                            </label>
                            <div class="input-group">
                                <input type="text"
                                       name="fullname"
                                       class="form-control"
                                       placeholder="เช่น ดร.สมชาย กุญชร ณอยุธยา"
                                       value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8') : '' ?>">
                                <button class="btn btn-primary" type="submit">
                                    แยกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">คำนำหน้า</label>
                            <input type="text" class="form-control" readonly
                                   value="<?= htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" readonly
                                   value="<?= htmlspecialchars($result['given'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" readonly
                                   value="<?= htmlspecialchars($result['family'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
