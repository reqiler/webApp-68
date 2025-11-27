<?php
// index.php — แสดงผลทันที ไม่มีฟอร์ม
// ขนาดกำหนดตรงนี้
$starHeight   = 5;
$matrixRows   = 5;
$matrixCols   = 5;
$triangleRows = 5;
$boxNumRows   = 5;
$invertedRows = 5;

$out = "";

// -----------------------------
// Pattern 1: Left-aligned stars (triangle)
// -----------------------------
$out .= "=== รูปที่ 1: Left-aligned stars (triangle) ===\n\n";

// for
$out .= "[ใช้ for]\n";
for ($i = 1; $i <= $starHeight; $i++) {
    for ($j = 1; $j <= $i; $j++) $out .= "*";
    $out .= "\n";
}
$out .= "\n";

// while
$out .= "[ใช้ while]\n";
$i = 1;
while ($i <= $starHeight) {
    $j = 1;
    while ($j <= $i) {
        $out .= "*";
        $j++;
    }
    $out .= "\n";
    $i++;
}
$out .= "\n";

// do-while
$out .= "[ใช้ do-while]\n";
$i = 1;
do {
    $j = 1;
    do {
        $out .= "*";
        $j++;
    } while ($j <= $i);
    $out .= "\n";
    $i++;
} while ($i <= $starHeight);
$out .= "\n\n";

// -----------------------------
// Pattern 2: Matrix rows (1 1 1 ... / 2 2 2 ...)
// -----------------------------
$out .= "=== รูปที่ 2: Matrix rows ===\n\n";

// for
$out .= "[ใช้ for]\n";
for ($r = 1; $r <= $matrixRows; $r++) {
    for ($c = 1; $c <= $matrixCols; $c++) {
        $out .= $r;
        if ($c < $matrixCols) $out .= " ";
    }
    $out .= "\n";
}
$out .= "\n";

// while
$out .= "[ใช้ while]\n";
$r = 1;
while ($r <= $matrixRows) {
    $c = 1;
    while ($c <= $matrixCols) {
        $out .= $r;
        if ($c < $matrixCols) $out .= " ";
        $c++;
    }
    $out .= "\n";
    $r++;
}
$out .= "\n";

// do-while
$out .= "[ใช้ do-while]\n";
$r = 1;
do {
    $c = 1;
    do {
        $out .= $r;
        if ($c < $matrixCols) $out .= " ";
        $c++;
    } while ($c <= $matrixCols);
    $out .= "\n";
    $r++;
} while ($r <= $matrixRows);
$out .= "\n\n";

// -----------------------------
// Pattern 3: Growing number triangle (1 / 2 2 / 3 3 3)
// -----------------------------
$out .= "=== รูปที่ 3: Growing number triangle ===\n\n";

// for
$out .= "[ใช้ for]\n";
for ($i = 1; $i <= $triangleRows; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        $out .= $i;
        if ($j < $i) $out .= " ";
    }
    $out .= "\n";
}
$out .= "\n";

// while
$out .= "[ใช้ while]\n";
$i = 1;
while ($i <= $triangleRows) {
    $j = 1;
    while ($j <= $i) {
        $out .= $i;
        if ($j < $i) $out .= " ";
        $j++;
    }
    $out .= "\n";
    $i++;
}
$out .= "\n";

// do-while
$out .= "[ใช้ do-while]\n";
$i = 1;
do {
    $j = 1;
    do {
        $out .= $i;
        if ($j < $i) $out .= " ";
        $j++;
    } while ($j <= $i);
    $out .= "\n";
    $i++;
} while ($i <= $triangleRows);
$out .= "\n\n";

// -----------------------------
// Pattern 4: Boxed numbers with star border
// -----------------------------
$out .= "=== รูปที่ 4: Boxed numbers with star border ===\n\n";

// for
$out .= "[ใช้ for]\n";
$width = $matrixCols + 2;
for ($s = 0; $s < $width; $s++) {
    $out .= "*";
    if ($s < $width - 1) $out .= " ";
}
$out .= "\n";
for ($r = 1; $r <= $boxNumRows; $r++) {
    $out .= "* ";
    for ($c = 1; $c <= $matrixCols; $c++) {
        $out .= $r;
        if ($c < $matrixCols) $out .= " ";
    }
    $out .= " *\n";
}
for ($s = 0; $s < $width; $s++) {
    $out .= "*";
    if ($s < $width - 1) $out .= " ";
}
$out .= "\n\n";

// while
$out .= "[ใช้ while]\n";
$s = 0;
while ($s < $width) {
    $out .= "*";
    if ($s < $width - 1) $out .= " ";
    $s++;
}
$out .= "\n";
$r = 1;
while ($r <= $boxNumRows) {
    $out .= "* ";
    $c = 1;
    while ($c <= $matrixCols) {
        $out .= $r;
        if ($c < $matrixCols) $out .= " ";
        $c++;
    }
    $out .= " *\n";
    $r++;
}
$s = 0;
while ($s < $width) {
    $out .= "*";
    if ($s < $width - 1) $out .= " ";
    $s++;
}
$out .= "\n\n";

// do-while
$out .= "[ใช้ do-while]\n";
$s = 0;
if ($width > 0) {
    do {
        $out .= "*";
        if ($s < $width - 1) $out .= " ";
        $s++;
    } while ($s < $width);
}
$out .= "\n";
$r = 1;
if ($boxNumRows > 0) {
    do {
        $out .= "* ";
        $c = 1;
        if ($matrixCols > 0) {
            do {
                $out .= $r;
                if ($c < $matrixCols) $out .= " ";
                $c++;
            } while ($c <= $matrixCols);
        }
        $out .= " *\n";
        $r++;
    } while ($r <= $boxNumRows);
}
$s = 0;
if ($width > 0) {
    do {
        $out .= "*";
        if ($s < $width - 1) $out .= " ";
        $s++;
    } while ($s < $width);
}
$out .= "\n\n";

// -----------------------------
// Pattern 5: Inverted number triangle (3 3 3 / 2 2 / 1)
// -----------------------------
$out .= "=== รูปที่ 5: Inverted number triangle ===\n\n";

// for
$out .= "[ใช้ for]\n";
for ($i = $invertedRows; $i >= 1; $i--) {
    for ($j = 1; $j <= $i; $j++) {
        $out .= $i;
        if ($j < $i) $out .= " ";
    }
    $out .= "\n";
}
$out .= "\n";

// while
$out .= "[ใช้ while]\n";
$i = $invertedRows;
while ($i >= 1) {
    $j = 1;
    while ($j <= $i) {
        $out .= $i;
        if ($j < $i) $out .= " ";
        $j++;
    }
    $out .= "\n";
    $i--;
}
$out .= "\n";

// do-while
$out .= "[ใช้ do-while]\n";
$i = $invertedRows;
if ($i >= 1) {
    do {
        $j = 1;
        do {
            $out .= $i;
            if ($j < $i) $out .= " ";
            $j++;
        } while ($j <= $i);
        $out .= "\n";
        $i--;
    } while ($i >= 1);
}
$out .= "\n\n";
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>สร้าง Loop</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, "Roboto Mono", monospace; padding:20px; background:#f6f8fa; color:#222; }
    h1 { margin:0 0 12px; font-size:18px; }
    pre { background:#f6f8fa; color:#222; padding:14px; border-radius:6px; overflow:auto; line-height:1.35; white-space:pre; }
    .meta { margin-bottom:12px; color:#555; font-size:14px; }
  </style>
</head>
<body>
  <pre><?= htmlspecialchars($out) ?></pre>
</body>
</html>
