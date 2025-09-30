<?php
require_once '../config/database.php';

// Include TCPDF library
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

header('Content-Type: application/json');

class BirthCertificatePDF extends TCPDF {
    // Add custom methods if needed3
}

try {
    $birth_id = isset($_GET['birth_id']) ? intval($_GET['birth_id']) : 0;
    
    if ($birth_id <= 0) {
        throw new Exception('Invalid birth record ID');
    }

    // Fetch birth record data
    $database = new Database();
    $pdo = $database->getConnection();
    
    // Fetch main birth record
    $birthSql = "SELECT * FROM birth_records WHERE birth_id = ?";
    $birthStmt = $pdo->prepare($birthSql);
    $birthStmt->execute([$birth_id]);
    $birthRecord = $birthStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$birthRecord) {
        throw new Exception('Birth record not found');
    }

    // Fetch related records
    $motherSql = "SELECT * FROM parents_information WHERE birth_id = ? AND parent_type = 'Mother'";
    $motherStmt = $pdo->prepare($motherSql);
    $motherStmt->execute([$birth_id]);
    $motherInfo = $motherStmt->fetch(PDO::FETCH_ASSOC) ?: [];

    $fatherSql = "SELECT * FROM parents_information WHERE birth_id = ? AND parent_type = 'Father'";
    $fatherStmt = $pdo->prepare($fatherSql);
    $fatherStmt->execute([$birth_id]);
    $fatherInfo = $fatherStmt->fetch(PDO::FETCH_ASSOC) ?: [];

    $marriageSql = "SELECT * FROM parents_marriage WHERE birth_id = ?";
    $marriageStmt = $pdo->prepare($marriageSql);
    $marriageStmt->execute([$birth_id]);
    $marriageInfo = $marriageStmt->fetch(PDO::FETCH_ASSOC) ?: [];

    $attendantSql = "SELECT * FROM birth_attendants WHERE birth_id = ?";
    $attendantStmt = $pdo->prepare($attendantSql);
    $attendantStmt->execute([$birth_id]);
    $attendantInfo = $attendantStmt->fetch(PDO::FETCH_ASSOC) ?: [];

    $informantSql = "SELECT * FROM informants WHERE birth_id = ?";
    $informantStmt = $pdo->prepare($informantSql);
    $informantStmt->execute([$birth_id]);
    $informantInfo = $informantStmt->fetch(PDO::FETCH_ASSOC) ?: [];

    // Create PDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('Civil Registry System');
    $pdf->SetAuthor('Civil Registry Office');
    $pdf->SetTitle('Certificate of Live Birth - ' . $birthRecord['registry_number']);
    $pdf->SetSubject('Birth Certificate');
    
    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // Set margins
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(true, 15);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 10);
    
    // Certificate Header - Match original template
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 6, '(Revised August 2016) Republic of the Philippines', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(0, 6, 'OFFICE OF THE CIVIL REGISTRAR GENERAL', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 8, 'CERTIFICATE OF LIVE BIRTH', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    
    // Add some space
    $pdf->Ln(2);
    
    // Top info table - Match original template layout
    $pdf->SetFont('helvetica', '', 9);
    
    // Create a table with 3 columns for Province, Registry No., City/Municipality
    $pdf->Cell(60, 6, 'Province', 'LTR', 0, 'L');
    $pdf->Cell(60, 6, 'Registry No. ' . ($birthRecord['registry_number'] ?? ''), 'LTR', 0, 'L');
    $pdf->Cell(60, 6, 'City/Municipality ' . ($birthRecord['birth_address_city'] ?? ''), 'LTR', 1, 'L');
    
    // Add border bottom to complete the table
    $pdf->Cell(60, 0.5, '', 'LBR', 0, 'L');
    $pdf->Cell(60, 0.5, '', 'LBR', 0, 'L');
    $pdf->Cell(60, 0.5, '', 'LBR', 1, 'L');
    
    $pdf->Ln(3);
    
    // 1. NAME field - Match original template
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, '1. NAME (First) (Middle) (Last)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $childName = trim(($birthRecord['child_first_name'] ?? '') . ' ' . 
                     ($birthRecord['child_middle_name'] ?? '') . ' ' . 
                     ($birthRecord['child_last_name'] ?? ''));
    $pdf->Cell(0, 7, $childName ?: '', 'B', 1, 'L');
    $pdf->Ln(2);
    
    // 2. SEX and 3. DATE OF BIRTH in same line
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(90, 5, '2. SEX (Male / Female)', 0, 0, 'L');
    $pdf->Cell(90, 5, '3. DATE OF BIRTH (Day) (Month) (Year)', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 10);
    $birthDate = $birthRecord['date_of_birth'] ? date('j F Y', strtotime($birthRecord['date_of_birth'])) : '';
    $pdf->Cell(90, 7, $birthRecord['sex'] ?? '', 'B', 0, 'L');
    $pdf->Cell(90, 7, $birthDate, 'B', 1, 'L');
    $pdf->Ln(2);
    
    // 4. PLACE OF BIRTH
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, '4. PLACE OF BIRTH (Name of Hospital/Clinic/Institution) (City/Municipality) (Province)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 7, $birthRecord['place_of_birth'] ?? '', 'B', 1, 'L');
    
    // House No., St. Barangay
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, 'House No., St. Barangay', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $birthAddress = trim(($birthRecord['birth_address_house'] ?? '') . ' ' . 
                        ($birthRecord['birth_address_barangay'] ?? '') . ', ' .
                        ($birthRecord['birth_address_city'] ?? '') . ', ' .
                        ($birthRecord['birth_address_province'] ?? '') . ', ' .
                        ($birthRecord['birth_address_region'] ?? '') . ': ' .
                        ($birthRecord['birth_address_zip'] ?? ''));
    $pdf->Cell(0, 7, $birthAddress ?: '', 'B', 1, 'L');
    $pdf->Ln(2);
    
    // 5a, 5b, 5c in same line
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(60, 5, '5a. TYPE OF BIRTH (Single Twin Triplet, etc.)', 0, 0, 'L');
    $pdf->Cell(60, 5, '5b. IF MULTIPLE BIRTH, CHILD WAS (First, Second, Third, etc.)', 0, 0, 'L');
    $pdf->Cell(60, 5, '5c. BIRTH ORDER (First, Second, Third, etc.)', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 10);
    $multipleOrder = $birthRecord['birth_order'] === '1' ? 'First' : 
                    ($birthRecord['birth_order'] === '2' ? 'Second' : 
                    ($birthRecord['birth_order'] === '3' ? 'Third' : ''));
    $pdf->Cell(60, 7, $birthRecord['type_of_birth'] ?? '', 'B', 0, 'L');
    $pdf->Cell(60, 7, $multipleOrder, 'B', 0, 'L');
    $pdf->Cell(60, 7, $birthRecord['birth_order'] ?? '', 'B', 1, 'L');
    $pdf->Ln(5);
    
    // 7. MAIDEN NAME (Mother's information)
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, '7. MAIDEN NAME (First) (Middle) (Last)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $motherName = trim(($motherInfo['first_name'] ?? '') . ' ' . 
                    ($motherInfo['middle_name'] ?? '') . ' ' . 
                    ($motherInfo['last_name'] ?? ''));
    $pdf->Cell(0, 7, $motherName ?: '', 'B', 1, 'L');
    $pdf->Ln(2);
    
    // 8. CITIZENSHIP and 9. RELIGION in same line
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(90, 5, '8. CITIZENSHIP', 0, 0, 'L');
    $pdf->Cell(90, 5, '9. RELIGION/RELIGIOUS SECT', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(90, 7, $motherInfo['citizenship'] ?? '', 'B', 0, 'L');
    $pdf->Cell(90, 7, $motherInfo['religion'] ?? '', 'B', 1, 'L');
    $pdf->Ln(2);
    
    // 10a, 10b, 10c, 11, 12 in same line
    $pdf->SetFont('helvetica', '', 9);
    $cellWidth = 36;
    $pdf->Cell($cellWidth, 5, '10a. Children born alive', 0, 0, 'L');
    $pdf->Cell($cellWidth, 5, '10b. Children still living', 0, 0, 'L');
    $pdf->Cell($cellWidth, 5, '10c. Children deceased', 0, 0, 'L');
    $pdf->Cell($cellWidth, 5, '11. OCCUPATION', 0, 0, 'L');
    $pdf->Cell($cellWidth, 5, '12. AGE', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell($cellWidth, 7, $motherInfo['children_born_alive'] ?? '0', 'B', 0, 'L');
    $pdf->Cell($cellWidth, 7, $motherInfo['children_still_living'] ?? '0', 'B', 0, 'L');
    $pdf->Cell($cellWidth, 7, $motherInfo['children_deceased'] ?? '0', 'B', 0, 'L');
    $pdf->Cell($cellWidth, 7, $motherInfo['occupation'] ?? '', 'B', 0, 'L');
    $pdf->Cell($cellWidth, 7, $motherInfo['age_at_birth'] ?? '', 'B', 1, 'L');
    $pdf->Ln(2);
    
    // 13. RESIDENCE
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, '13. RESIDENCE (House No., St. Barangay) (City/Municipality) (Province) (Country)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $motherAddress = trim(($motherInfo['house_no'] ?? '') . ' ' . 
                       ($motherInfo['barangay'] ?? '') . ' ' . 
                       ($motherInfo['city'] ?? '') . ' ' . 
                       ($motherInfo['province'] ?? '') . ' ' . 
                       ($motherInfo['country'] ?? ''));
    $pdf->Cell(0, 7, $motherAddress ?: '', 'B', 1, 'L');
    
    // Continue with Father's Information, Marriage, Attendant, etc. following the same pattern...
    // Add the remaining sections as needed
    
    $pdf->Ln(5);
    
    // Father's Information Section
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, '14. NAME (First) (Middle) (Last)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $fatherName = trim(($fatherInfo['first_name'] ?? '') . ' ' . 
                     ($fatherInfo['middle_name'] ?? '') . ' ' . 
                     ($fatherInfo['last_name'] ?? ''));
    $pdf->Cell(0, 7, $fatherName ?: '', 'B', 1, 'L');
    $pdf->Ln(2);
    
    // Father's details
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(45, 5, '15. CITIZENSHIP', 0, 0, 'L');
    $pdf->Cell(45, 5, '16. RELIGION/RELIGIOUS SECT', 0, 0, 'L');
    $pdf->Cell(45, 5, '17. OCCUPATION', 0, 0, 'L');
    $pdf->Cell(45, 5, '18. AGE at the time of this birth', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(45, 7, $fatherInfo['citizenship'] ?? '', 'B', 0, 'L');
    $pdf->Cell(45, 7, $fatherInfo['religion'] ?? '', 'B', 0, 'L');
    $pdf->Cell(45, 7, $fatherInfo['occupation'] ?? '', 'B', 0, 'L');
    $pdf->Cell(45, 7, $fatherInfo['age_at_birth'] ?? '', 'B', 1, 'L');
    $pdf->Ln(2);
    
    // Father's address
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, '19. RESIDENCE (House No., St. Barangay) (City/Municipality) (Province) (Country)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $fatherAddress = trim(($fatherInfo['house_no'] ?? '') . ' ' . 
                        ($fatherInfo['barangay'] ?? '') . ' ' . 
                        ($fatherInfo['city'] ?? '') . ' ' . 
                        ($fatherInfo['province'] ?? '') . ' ' . 
                        ($fatherInfo['country'] ?? ''));
    $pdf->Cell(0, 7, $fatherAddress ?: '', 'B', 1, 'L');
    
    $pdf->Ln(5);
    
    // Marriage Information
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 6, 'MARRIAGE OF PARENTS (If not married, accomplish Affidavit of Acknowledgment/Admission of Paternity at the back.)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(90, 5, '20a. DATE (Month) (Day) (Year)', 0, 0, 'L');
    $pdf->Cell(90, 5, '20b. PLACE (City / Municipality) (Province) (Country)', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 10);
    $marriageDate = $marriageInfo['marriage_date'] ? date('F j, Y', strtotime($marriageInfo['marriage_date'])) : '';
    $marriagePlace = trim(($marriageInfo['marriage_place_city'] ?? '') . ' ' . 
                          ($marriageInfo['marriage_place_province'] ?? '') . ' ' . 
                          ($marriageInfo['marriage_place_country'] ?? ''));
    $pdf->Cell(90, 7, $marriageDate, 'B', 0, 'L');
    $pdf->Cell(90, 7, $marriagePlace, 'B', 1, 'L');
    
    // Add more sections as needed for attendant, informant, etc.
    
    // Output PDF
    $pdf->Output('birth_certificate_' . $birthRecord['registry_number'] . '.pdf', 'D');
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error generating certificate: ' . $e->getMessage()
    ]);
}
?>