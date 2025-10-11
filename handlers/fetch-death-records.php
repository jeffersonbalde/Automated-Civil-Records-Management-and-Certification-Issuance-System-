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

    // Build query with search - RETURN INDIVIDUAL NAME FIELDS
    $query = "SELECT 
                dr.death_id,
                dr.registry_number,
                dr.first_name,
                dr.middle_name,
                dr.last_name,
                dr.sex,
                dr.date_of_death,
                dr.date_of_birth,
                dr.place_of_death,
                dr.civil_status,
                dr.date_registered,
                'active' as status
              FROM death_records dr
              WHERE 1=1";

    $countQuery = "SELECT COUNT(*) as total FROM death_records dr WHERE 1=1";

    $params = [];
    $countParams = [];

    // Add search condition
    if (!empty($search)) {
        $query .= " AND (dr.first_name LIKE ? OR dr.last_name LIKE ? 
                     OR dr.middle_name LIKE ? OR dr.registry_number LIKE ?)";
        $countQuery .= " AND (dr.first_name LIKE ? OR dr.last_name LIKE ? 
                         OR dr.middle_name LIKE ? OR dr.registry_number LIKE ?)";
        $searchTerm = "%$search%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        $countParams = array_merge($countParams, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }

    // Add date range filter (using date_of_death for death records)
    if (!empty($dateFrom)) {
        $query .= " AND dr.date_of_death >= ?";
        $countQuery .= " AND dr.date_of_death >= ?";
        $params[] = $dateFrom;
        $countParams[] = $dateFrom;
    }

    if (!empty($dateTo)) {
        $query .= " AND dr.date_of_death <= ?";
        $countQuery .= " AND dr.date_of_death <= ?";
        $params[] = $dateTo;
        $countParams[] = $dateTo;
    }

    // Add sorting
    $sort = $_GET['sort'] ?? 'newest';
    switch ($sort) {
        case 'oldest':
            $query .= " ORDER BY dr.date_registered ASC";
            break;
        case 'name':
            $query .= " ORDER BY dr.first_name ASC, dr.last_name ASC";
            break;
        case 'newest':
        default:
            $query .= " ORDER BY dr.date_registered DESC";
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
    $stats = getDeathStats($pdo, $search, $dateFrom, $dateTo);

    echo json_encode([
        'success' => true,
        'records' => $records,
        'totalRecords' => $totalRecords,
        'stats' => $stats,
        'currentPage' => $page,
        'totalPages' => ceil($totalRecords / $limit)
    ]);
} catch (Exception $e) {
    error_log('Fetch death records error: ' . $e->getMessage());

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

function getDeathStats($pdo, $search = '', $dateFrom = '', $dateTo = '')
{
    $searchCondition = "";
    $dateCondition = "";
    $params = [];

    if (!empty($search)) {
        $searchCondition = " AND (first_name LIKE ? OR last_name LIKE ? 
                            OR middle_name LIKE ? OR registry_number LIKE ?)";
        $searchTerm = "%$search%";
        $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
    }

    if (!empty($dateFrom)) {
        $dateCondition .= " AND date_of_death >= ?";
        $params[] = $dateFrom;
    }

    if (!empty($dateTo)) {
        $dateCondition .= " AND date_of_death <= ?";
        $params[] = $dateTo;
    }

    // Total records
    $totalSql = "SELECT COUNT(*) as count FROM death_records WHERE 1=1" . $searchCondition . $dateCondition;
    $totalStmt = $pdo->prepare($totalSql);
    $totalStmt->execute($params);
    $total = $totalStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // This month
    $monthSql = "SELECT COUNT(*) as count FROM death_records 
                 WHERE MONTH(date_registered) = MONTH(CURRENT_DATE()) 
                 AND YEAR(date_registered) = YEAR(CURRENT_DATE())" . $searchCondition . $dateCondition;
    $monthStmt = $pdo->prepare($monthSql);
    $monthStmt->execute($params);
    $thisMonth = $monthStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Pending - records from last 7 days (assuming they need review)
    $pendingSql = "SELECT COUNT(*) as count FROM death_records 
                   WHERE date_registered >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)" . $searchCondition . $dateCondition;
    $pendingStmt = $pdo->prepare($pendingSql);
    $pendingStmt->execute($params);
    $pending = $pendingStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Certified - records older than 7 days (assuming they're processed)
    $certifiedSql = "SELECT COUNT(*) as count FROM death_records 
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