<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'student') {
    echo "Access denied!";
    exit;
}

include "../config/database.php";
require '../libraries/fpdf/fpdf.php'; // path to fpdf.php

$email = $_SESSION['email'];

// Get the user's subjects and marks
$sql = "SELECT subject, marks FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Initialize PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Your Result', 0, 1, 'C');
$pdf->Ln(10);

// Table header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Subject', 1);
$pdf->Cell(40, 10, 'Marks', 1);
$pdf->Ln();

// Table body
$pdf->SetFont('Arial', '', 12);
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(80, 10, $row['subject'], 1);
    $pdf->Cell(40, 10, $row['marks'], 1);
    $pdf->Ln();
}

// Output PDF to browser
$pdf->Output('I', 'Result.pdf'); // 'I' = inline view, 'D' = download
exit;
?>
