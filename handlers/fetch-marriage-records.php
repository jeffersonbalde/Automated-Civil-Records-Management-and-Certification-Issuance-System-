<?php
session_start();
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

try {
    $database = new Database();
    $pdo = $database->getConnection();

    if (!$pdo) {
        throw new Exception('Database connection failed');
    }

    // Get search and filter parameters
    $search = $_GET['search'] ?? '';
    $page = max(1, intval($_GET['page'] ?? 1));
    $limit = max(1, intval($_GET['limit'] ?? 10));
    $offset = ($page - 1) * $limit;
    $dateFrom = $_GET['date_from'] ?? '';
    $dateTo = $_GET['date_to'] ?? '';

    // Build query with search
    $query = "SELECT 
                mr.marriage_id,
                mr.registry_number,
                CONCAT(mr.husband_first_name, ' ', COALESCE(mr.husband_middle_name, ''), ' ', mr.husband_last_name) as husband_full_name,
                CONCAT(mr.wife_first_name, ' ', COALESCE(mr.wife_middle_name, ''), ' ', mr.wife_last_name) as wife_full_name,
                mr.date_of_marriage,
                mr.place_of_marriage,
                mr.husband_birthdate,
                mr.wife_birthdate,
                mr.husband_civil_status,
                mr.wife_civil_status,
                mr.date_registered,
                'active' as status  -- Default status since column doesn't exist
              FROM marriage_records mr
              WHERE 1=1";

    $countQuery = "SELECT COUNT(*) as total FROM marriage_records mr WHERE 1=1";

    $params = [];
    $countParams = [];

    // Add search condition
    if (!empty($search)) {
        $query .= " AND (mr.husband_first_name LIKE ? OR mr.husband_last_name LIKE ? 
                     OR mr.wife_first_name LIKE ? OR mr.wife_last_name LIKE ? 
                     OR mr.registry_number LIKE ?)";
        $countQuery .= " AND (mr.husband_first_name LIKE ? OR mr.husband_last_name LIKE ? 
                         OR mr.wife_first_name LIKE ? OR mr.wife_last_name LIKE ? 
                         OR mr.registry_number LIKE ?)";
        $searchTerm = "%$search%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        $countParams = array_merge($countParams, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }

    // Add date range filter
    if (!empty($dateFrom)) {
        $query .= " AND mr.date_of_marriage >= ?";
        $countQuery .= " AND mr.date_of_marriage >= ?";
        $params[] = $dateFrom;
        $countParams[] = $dateFrom;
    }

    if (!empty($dateTo)) {
        $query .= " AND mr.date_of_marriage <= ?";
        $countQuery .= " AND mr.date_of_marriage <= ?";
        $params[] = $dateTo;
        $countParams[] = $dateTo;
    }

    // Add sorting
    $sort = $_GET['sort'] ?? 'newest';
    switch ($sort) {
        case 'oldest':
            $query .= " ORDER BY mr.date_registered ASC";
            break;
        case 'name':
            $query .= " ORDER BY mr.husband_first_name ASC, mr.husband_last_name ASC";
            break;
        case 'newest':
        default:
            $query .= " ORDER BY mr.date_registered DESC";
            break;
    }

    // Add limit and offset
    $query .= " LIMIT $limit OFFSET $offset";

    // Execute main query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get total count
    $countStmt = $pdo->prepare($countQuery);
    $countStmt->execute($countParams);
    $totalResult = $countStmt->fetch(PDO::FETCH_ASSOC);
    $totalRecords = $totalResult['total'];

    // Get stats
    $stats = getMarriageStats($pdo, $search, $dateFrom, $dateTo);

    echo json_encode([
        'success' => true,
        'records' => $records,
        'totalRecords' => $totalRecords,
        'stats' => $stats,
        'currentPage' => $page,
        'totalPages' => ceil($totalRecords / $limit)
    ]);
} catch (Exception $e) {
    error_log('Fetch marriage records error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Error fetching records: ' . $e->getMessage(),
        'records' => [],
        'totalRecords' => 0,
        'stats' => [
            'total' => 0,
            'thisMonth' => 0,
            'pending' => 0,
            'certified' => 0
        ]
    ]);
}

function getMarriageStats($pdo, $search = '', $dateFrom = '', $dateTo = '')
{
    $searchCondition = "";
    $dateCondition = "";
    $params = [];

    if (!empty($search)) {
        $searchCondition = " AND (husband_first_name LIKE ? OR husband_last_name LIKE ? 
                            OR wife_first_name LIKE ? OR wife_last_name LIKE ? 
                            OR registry_number LIKE ?)";
        $searchTerm = "%$search%";
        $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm];
    }

    if (!empty($dateFrom)) {
        $dateCondition .= " AND date_of_marriage >= ?";
        $params[] = $dateFrom;
    }

    if (!empty($dateTo)) {
        $dateCondition .= " AND date_of_marriage <= ?";
        $params[] = $dateTo;
    }

    // Total records
    $totalSql = "SELECT COUNT(*) as count FROM marriage_records WHERE 1=1" . $searchCondition . $dateCondition;
    $totalStmt = $pdo->prepare($totalSql);
    $totalStmt->execute($params);
    $total = $totalStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // This month
    $monthSql = "SELECT COUNT(*) as count FROM marriage_records 
                 WHERE MONTH(date_registered) = MONTH(CURRENT_DATE()) 
                 AND YEAR(date_registered) = YEAR(CURRENT_DATE())" . $searchCondition . $dateCondition;
    $monthStmt = $pdo->prepare($monthSql);
    $monthStmt->execute($params);
    $thisMonth = $monthStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Pending - records from last 7 days (assuming they need review)
    $pendingSql = "SELECT COUNT(*) as count FROM marriage_records 
                   WHERE date_registered >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)" . $searchCondition . $dateCondition;
    $pendingStmt = $pdo->prepare($pendingSql);
    $pendingStmt->execute($params);
    $pending = $pendingStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Certified - records older than 7 days (assuming they're processed)
    $certifiedSql = "SELECT COUNT(*) as count FROM marriage_records 
                     WHERE date_registered < DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)" . $searchCondition . $dateCondition;
    $certifiedStmt = $pdo->prepare($certifiedSql);
    $certifiedStmt->execute($params);
    $certified = $certifiedStmt->fetch(PDO::FETCH_ASSOC)['count'];

    return [
        'total' => (int)$total,
        'thisMonth' => (int)$thisMonth,
        'pending' => (int)$pending,
        'certified' => (int)$certified
    ];
}
?>