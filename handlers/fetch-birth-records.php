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

    // Build query with search - CORRECTED COLUMN NAMES
    $query = "SELECT 
                br.birth_id,
                br.registry_number,
                CONCAT(br.child_first_name, ' ', COALESCE(br.child_middle_name, ''), ' ', br.child_last_name) as full_name,
                br.date_of_birth,
                br.place_of_birth,
                CONCAT(COALESCE(m.first_name, ''), ' & ', COALESCE(f.first_name, '')) as parents,
                br.date_registered,
                'registered' as status  -- Default status since column doesn't exist
              FROM birth_records br
              LEFT JOIN parents_information m ON br.birth_id = m.birth_id AND m.parent_type = 'Mother'
              LEFT JOIN parents_information f ON br.birth_id = f.birth_id AND f.parent_type = 'Father'
              WHERE 1=1";

    $countQuery = "SELECT COUNT(*) as total FROM birth_records br WHERE 1=1";

    $params = [];
    $countParams = [];

    // Add search condition
    if (!empty($search)) {
        $query .= " AND (br.child_first_name LIKE ? OR br.child_last_name LIKE ? OR br.registry_number LIKE ?)";
        $countQuery .= " AND (br.child_first_name LIKE ? OR br.child_last_name LIKE ? OR br.registry_number LIKE ?)";
        $searchTerm = "%$search%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        $countParams = array_merge($countParams, [$searchTerm, $searchTerm, $searchTerm]);
    }


    // Add sorting
    $sort = $_GET['sort'] ?? 'newest';
    switch ($sort) {
        case 'oldest':
            $query .= " ORDER BY br.date_registered ASC";
            break;
        case 'name':
            $query .= " ORDER BY br.child_first_name ASC, br.child_last_name ASC";
            break;
        case 'newest':
        default:
            $query .= " ORDER BY br.date_registered DESC";
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
    $stats = getBirthStats($pdo, $search);

    echo json_encode([
        'success' => true,
        'records' => $records,
        'totalRecords' => $totalRecords,
        'stats' => $stats,
        'currentPage' => $page,
        'totalPages' => ceil($totalRecords / $limit)
    ]);
} catch (Exception $e) {
    error_log('Fetch birth records error: ' . $e->getMessage());

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

function getBirthStats($pdo, $search = '')
{
    $searchCondition = "";
    $params = [];

    if (!empty($search)) {
        $searchCondition = " AND (child_first_name LIKE ? OR child_last_name LIKE ? OR registry_number LIKE ?)";
        $searchTerm = "%$search%";
        $params = [$searchTerm, $searchTerm, $searchTerm];
    }

    // Total records
    $totalSql = "SELECT COUNT(*) as count FROM birth_records WHERE 1=1" . $searchCondition;
    $totalStmt = $pdo->prepare($totalSql);
    $totalStmt->execute($params);
    $total = $totalStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // This month
    $monthSql = "SELECT COUNT(*) as count FROM birth_records 
                 WHERE MONTH(date_registered) = MONTH(CURRENT_DATE()) 
                 AND YEAR(date_registered) = YEAR(CURRENT_DATE())" . $searchCondition;
    $monthStmt = $pdo->prepare($monthSql);
    $monthStmt->execute($params);
    $thisMonth = $monthStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Since we don't have status column, we'll use some logic for pending/certified
    // Pending - records from last 7 days (assuming they need review)
    $pendingSql = "SELECT COUNT(*) as count FROM birth_records 
                   WHERE date_registered >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)" . $searchCondition;
    $pendingStmt = $pdo->prepare($pendingSql);
    $pendingStmt->execute($params);
    $pending = $pendingStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Certified - records older than 7 days (assuming they're processed)
    $certifiedSql = "SELECT COUNT(*) as count FROM birth_records 
                     WHERE date_registered < DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)" . $searchCondition;
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
