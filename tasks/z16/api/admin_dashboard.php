<?php
echo '<h2>Panel Administratora - Statystyki Systemu CRM</h2>';

try {
    // i. Wyświetlenie ilości wszystkich zapytań wygenerowanych przez wszystkich klientów.
    $stmt_total_questions = $conn->prepare("SELECT COUNT(id) AS total_questions FROM posts");
    $stmt_total_questions->execute();
    $result_total_questions = $stmt_total_questions->get_result();
    $total_questions = $result_total_questions->fetch_assoc()['total_questions'];
    $stmt_total_questions->close();
    echo '<p><strong>Ilość wszystkich zapytań klientów:</strong> ' . htmlspecialchars($total_questions) . '</p>';

    // ii. Wyświetlenie ilości wszystkich odpowiedzi udzielonych przez wszystkich pracowników.
    $stmt_total_answers = $conn->prepare("SELECT COUNT(id) AS total_answers FROM posts WHERE employee_answer IS NOT NULL");
    $stmt_total_answers->execute();
    $result_total_answers = $stmt_total_answers->get_result();
    $total_answers = $result_total_answers->fetch_assoc()['total_answers'];
    $stmt_total_answers->close();
    echo '<p><strong>Ilość wszystkich odpowiedzi pracowników:</strong> ' . htmlspecialchars($total_answers) . '</p>';

    // iii. Wyświetlenie ilości wszystkich odpowiedzi udzielonych przez wszystkich pracowników z pogrupowaniem wg pracowników.
    echo '<h4>Odpowiedzi pogrupowane wg pracowników:</h4>';
    $stmt_employee_answers = $conn->prepare("
        SELECT u.username, COUNT(p.id) AS num_answers
        FROM users u
        JOIN posts p ON u.id = p.employee_id
        WHERE u.user_type = 'employee' AND p.employee_answer IS NOT NULL
        GROUP BY u.username
        ORDER BY num_answers DESC
    ");
    $stmt_employee_answers->execute();
    $result_employee_answers = $stmt_employee_answers->get_result();
    if ($result_employee_answers->num_rows > 0) {
        echo '<ul>';
        while ($data = $result_employee_answers->fetch_assoc()) {
            echo '<li>' . htmlspecialchars($data['username']) . ': ' . htmlspecialchars($data['num_answers']) . ' odpowiedzi</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Brak odpowiedzi od pracowników.</p>';
    }
    $stmt_employee_answers->close();

    // iv. Wyświetlenie ilości wszystkich odpowiedzi udzielonych przez wszystkich pracowników z pogrupowaniem wg zagadnień.
    echo '<h4>Odpowiedzi pogrupowane wg zagadnień:</h4>';
    $stmt_topic_answers = $conn->prepare("
        SELECT t.name AS topic_name, COUNT(p.id) AS num_answers
        FROM topics t
        JOIN posts p ON t.id = p.topic_id
        WHERE p.employee_answer IS NOT NULL
        GROUP BY t.name
        ORDER BY num_answers DESC
    ");
    $stmt_topic_answers->execute();
    $result_topic_answers = $stmt_topic_answers->get_result();
    if ($result_topic_answers->num_rows > 0) {
        echo '<ul>';
        while ($data = $result_topic_answers->fetch_assoc()) {
            echo '<li>' . htmlspecialchars($data['topic_name']) . ': ' . htmlspecialchars($data['num_answers']) . ' odpowiedzi</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Brak odpowiedzi dla zagadnień.</p>';
    }
    $stmt_topic_answers->close();

    // v. Wyświetlenie średniej ocen wszystkich pracowników, nadanych im przez klientów, z pogrupowaniem na pracowników.
    echo '<h4>Średnie oceny pracowników:</h4>';
    $stmt_employee_ratings = $conn->prepare("
        SELECT u.username, AVG(p.rating) AS avg_rating
        FROM users u
        JOIN posts p ON u.id = p.employee_id
        WHERE u.user_type = 'employee' AND p.rating IS NOT NULL
        GROUP BY u.username
        ORDER BY avg_rating DESC
    ");
    $stmt_employee_ratings->execute();
    $result_employee_ratings = $stmt_employee_ratings->get_result();
    if ($result_employee_ratings->num_rows > 0) {
        echo '<ul>';
        while ($data = $result_employee_ratings->fetch_assoc()) {
            echo '<li>' . htmlspecialchars($data['username']) . ': ' . htmlspecialchars(round($data['avg_rating'], 2)) . ' (średnia gwiazdek)</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Brak ocen dla pracowników.</p>';
    }
    $stmt_employee_ratings->close();

    // vi. Graficzna wizualizacja odzwierciedlająca szybkość i jakość pracy pracowników.
    echo '<h4>Wizualizacja pracy pracowników:</h4>';

    // Fetch all employees and their completed tickets and average ratings
    $stmt_performance = $conn->prepare("
        SELECT
            u.username,
            COUNT(CASE WHEN p.employee_answer IS NOT NULL THEN p.id END) AS completed_tickets,
            AVG(p.rating) AS avg_rating
        FROM users u
        LEFT JOIN posts p ON u.id = p.employee_id
        WHERE u.user_type = 'employee'
        GROUP BY u.username
        ORDER BY u.username ASC
    ");
    $stmt_performance->execute();
    $result_performance = $stmt_performance->get_result();
    $employee_performance_data = $result_performance->fetch_all(MYSQLI_ASSOC);
    $stmt_performance->close();

    // Calculate total tickets and average tickets per employee
    $total_completed_tickets_sum = 0;
    foreach ($employee_performance_data as $data) {
        $total_completed_tickets_sum += $data['completed_tickets'];
    }
    $num_employees_with_data = count($employee_performance_data);
    $average_tickets_per_employee = ($num_employees_with_data > 0) ? $total_completed_tickets_sum / $num_employees_with_data : 0;

    echo '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">';
    echo '<thead><tr><th>Pracownik</th><th>Tempo pracy</th><th>Jakość pracy</th><th>Szczegóły</th></tr></thead><tbody>';

    if (empty($employee_performance_data)) {
        echo '<tr><td colspan="4">Brak danych o pracownikach.</td></tr>';
    } else {
        foreach ($employee_performance_data as $employee) {
            $tempo_icon = '';
            $quality_stars = '';
            $details_text = '';

            // Determine tempo icon
            if ($average_tickets_per_employee > 0) {
                if ($employee['completed_tickets'] < $average_tickets_per_employee * 0.5) {
                    $tempo_icon = '🐌 Ślimak';
                } elseif ($employee['completed_tickets'] < $average_tickets_per_employee * 0.8) {
                    $tempo_icon = '🐢 Żółw';
                } elseif ($employee['completed_tickets'] >= $average_tickets_per_employee * 0.8 && $employee['completed_tickets'] <= $average_tickets_per_employee * 1.2) {
                    $tempo_icon = '🧍 Człowiek';
                } elseif ($employee['completed_tickets'] > $average_tickets_per_employee * 1.2) {
                    $tempo_icon = '🐆 Puma';
                }
            } else {
                $tempo_icon = 'N/A (Brak danych o średniej)';
            }
            $details_text .= 'Ticketów: ' . htmlspecialchars($employee['completed_tickets']) . ' (Średnia: ' . htmlspecialchars(round($average_tickets_per_employee, 2)) . '). ';


            // Determine quality stars
            if ($employee['avg_rating'] !== null) {
                for ($i = 1; $i <= round($employee['avg_rating']); $i++) {
                    $quality_stars .= '&#9733;'; // Unicode star symbol
                }
                $quality_stars .= ' (' . htmlspecialchars(round($employee['avg_rating'], 2)) . ')';
            } else {
                $quality_stars = 'Brak ocen';
            }
            $details_text .= 'Ocena: ' . htmlspecialchars(round($employee['avg_rating'] ?? 0, 2));


            echo '<tr>';
            echo '<td>' . htmlspecialchars($employee['username']) . '</td>';
            echo '<td>' . $tempo_icon . '</td>';
            echo '<td>' . $quality_stars . '</td>';
            echo '<td><small>' . $details_text . '</small></td>';
            echo '</tr>';
        }
    }
    echo '</tbody></table>';

} catch (Exception $e) {
    error_log("Error fetching admin stats: " . $e->getMessage());
    echo '<div class="error">Wystąpił błąd podczas ładowania statystyk.</div>';
}
