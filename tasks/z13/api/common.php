<?php

function uid_of_user($conn,$user) {
	$users_stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
	$users_stmt->bind_param("s", $user);
	if (!$users_stmt->execute()) {
		echo "Error: " . $users_stmt->error;
		goto user_stmt_close;
	}
	$user_res = $users_stmt->get_result();
	if ($user_res->num_rows === 0) {
		echo "Invalid login or password";
		goto user_stmt_close;
	}
	$uid = $user_res->fetch_row()[0];
	user_stmt_close:
	$users_stmt->close();
	return $uid;
}


function render($conn, $uid) {
	$tasks_stmt = $conn->prepare("SELECT id, title FROM tasks WHERE uid = ?");
	$tasks_stmt->bind_param("i", $uid);
	if (!$tasks_stmt->execute()) {
		echo "Error: " . $tasks_stmt->error;
		goto tasks_stmt_close;
	}

	$tasks = $tasks_stmt->get_result();

	$my_subtasks_stmt = $conn->prepare("
		SELECT t.title as parent_title, s.title, s.state, s.id
		FROM subtasks s
		JOIN tasks t ON s.task_id = t.id 
		WHERE s.uid = ?"
	);
	$my_subtasks_stmt->bind_param("i", $uid);
	if (!$my_subtasks_stmt->execute()) {
		echo "Error: " . $my_subtasks_stmt->error;
		goto my_tasks_stmt_close;
	}
	$my_subtasks = $my_subtasks_stmt->get_result();

	$users_stmt = $conn->prepare("SELECT id, username FROM users");
	if (!$users_stmt->execute()) {
		echo "Error: " . $users_stmt->error;
		goto users_stmt_close;
	}
	$users = $users_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

	echo '<h1>My tasks:</h1>';
	while ($task = $tasks->fetch_assoc()) {
		$subtasks = subtasks_for_task($conn, $task['id']);
		echo '
		<div class="task">
			<h2>' . htmlentities($task['title']) . '</h2>';
		while ($sub = $subtasks->fetch_assoc()) {
			echo '<div ' . color_style($sub['state']) . '>';
			echo '<p>' . htmlentities($sub['title']) . '</p>';
			echo '<input 
				hx-post="/tasks/z13/api/update-progress.php"
				hx-swap="none"
				hx-trigger="change, delay:500ms"
				hx-vals=\'js:{
					"subtask_id": "' . $sub["id"] . '",
					"state": event.target.value
				}\'
				type="range" min="0" max="100" 
				value="'. $sub["state"] .'"
			>';
			echo '</div>';
		}
		echo '<form 
			hx-post="/tasks/z13/api/add-subtask.php" 
			hx-target="main" 
			hx-swap="innerHTML"
			>
			<input type="text" name="title" placeholder="New subtask title" required>
			<input type="hidden" name="task_id" value="' . $task['id'] . '">
			<select name="uid" required>';
			foreach ($users as $user) {
				echo '<option value="'. $user["id"] .'">' . $user["username"] . '</option>';
			}
		    echo '</select>
			<button type="submit">Add Subtask</button>
		</form>';
		echo '</div>';
	}
	echo '<h1>My subtasks:</h1>';
	while ($sub = $my_subtasks->fetch_assoc()) {
		echo '<div ' . color_style($sub['state']) . '>';
		echo '<p>' . 
			htmlentities($sub['parent_title']) . " -> " . 
			htmlentities($sub['title']) . ": " . $sub['state'] . '% done</p>';
		echo '</div>';
	}
	users_stmt_close:
	$users_stmt->close();
	my_tasks_stmt_close:
	$my_subtasks_stmt->close();
	tasks_stmt_close:
	$tasks_stmt->close();
}

function subtasks_for_task($conn, $task_id) {
	$subtasks_stmt = $conn->prepare("SELECT id, title, state FROM subtasks WHERE task_id = ?");
	$subtasks_stmt->bind_param("i", $task_id);
	if (!$subtasks_stmt->execute()) {
		echo "Error: " . $subtasks_stmt->error;
		return [];
	}
	$subtasks = $subtasks_stmt->get_result();
	$subtasks_stmt->close();
	return $subtasks;
}

function color_style($state) {
	if ($state == 0) {
		return 'style="color: red;"';
	} elseif ($state == 100) {
		return 'style="color: green;"';
	} else {
		return 'style="color: black;"';
	} 
}

function render_admin($conn) {
	echo '<h2>Panel Administratora - ToDo System</h2>';
	echo '<h3>Lista Użytkowników</h3>';
	try {
		$stmt_users = $conn->prepare("SELECT id, username FROM users ORDER BY username ASC");
		$stmt_users->execute();
		$result_users = $stmt_users->get_result();

		if ($result_users->num_rows > 0) {
			echo '<table border="1" cellpadding="5" cellspacing="0" style="width:50%; border-collapse: collapse;">';
			echo '<thead><tr><th>ID</th><th>Nazwa Użytkownika</th></tr></thead><tbody>';
			while ($user = $result_users->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($user['id']) . '</td>';
				echo '<td>' . htmlspecialchars($user['username']) . '</td>';
				echo '</tr>';
			}
			echo '</tbody></table>';
		} else {
			echo '<p>Brak użytkowników w systemie.</p>';
		}
		$stmt_users->close();
	} catch (Exception $e) {
		error_log("Error fetching users: " . $e->getMessage());
		echo '<div class="error">Wystąpił błąd podczas ładowania listy użytkowników.</div>';
	}

	echo '<br>'; // Spacer

	// --- Section 2: Task and Subtask Overview ---
	echo '<h3>Przegląd Zadań i Podzadań</h3>';
	try {
		$stmt_tasks = $conn->prepare("
			SELECT t.id AS task_id, t.title AS task_title, u.username AS task_owner,
				   s.id AS subtask_id, s.title AS subtask_title, su.username AS subtask_assignee, s.state AS subtask_state
			FROM tasks t
			JOIN users u ON t.uid = u.id
			LEFT JOIN subtasks s ON t.id = s.task_id
			LEFT JOIN users su ON s.uid = su.id
			ORDER BY t.id DESC, s.id ASC
		");
		$stmt_tasks->execute();
		$result_tasks = $stmt_tasks->get_result();

		if ($result_tasks->num_rows > 0) {
			$current_task_id = null;
			while ($row = $result_tasks->fetch_assoc()) {
				if ($row['task_id'] !== $current_task_id) {
					if ($current_task_id !== null) {
						echo '</ul>'; // Close previous subtask list
					}
					echo '<div>';
					echo '<strong>Zadanie ID: ' . htmlspecialchars($row['task_id']) . '</strong><br>';
					echo '<strong>Tytuł:</strong> ' . htmlspecialchars($row['task_title']) . '<br>';
					echo '<strong>Utworzone przez:</strong> ' . htmlspecialchars($row['task_owner']) . '<br>';
					echo '<h4>Podzadania:</h4><ul>';
					$current_task_id = $row['task_id'];
				}

				if ($row['subtask_id']) {
					$state_text = ($row['subtask_state'] == 100) ? 'Zakończone' : 'W toku';
					$state_color = ($row['subtask_state'] == 100) ? 'green' : 'orange';
					echo '<li>';
					echo 'ID: ' . htmlspecialchars($row['subtask_id']) . ' | ';
					echo 'Tytuł: ' . htmlspecialchars($row['subtask_title']) . ' | ';
					echo 'Przypisane do: ' . htmlspecialchars($row['subtask_assignee'] ?? 'N/A') . ' | ';
					echo 'Stan: <span style="color:' . $state_color . ';">' . $state_text . '</span>';
					echo '</li>';
				} else if ($row['subtask_id'] === null && $row['task_id'] === $current_task_id) {
					// If a task has no subtasks, this row will be fetched once without subtask details.
					// We only want to show "No subtasks" once per task.
					if ($current_task_id === $row['task_id'] && $result_tasks->num_rows === 1 && $row['subtask_id'] === null) {
						 echo '<li>Brak podzadań.</li>';
					}
				}
			}
			if ($current_task_id !== null) {
				echo '</ul></div>'; // Close last subtask list and task div
			}
		} else {
			echo '<p>Brak zadań w systemie.</p>';
		}
		$stmt_tasks->close();
	} catch (Exception $e) {
		error_log("Error fetching tasks/subtasks: " . $e->getMessage());
		echo '<div class="error">Wystąpił błąd podczas ładowania zadań i podzadań.</div>';
	}

	echo '<br>';

	echo '<h3>Wizualizacja Szybkości Pracy Pracowników</h3>';
	try {
		$stmt_employee_speed = $conn->prepare("
			SELECT u.id, u.username, COUNT(s.id) AS completed_subtasks
			FROM users u
			LEFT JOIN subtasks s ON u.id = s.uid AND s.state = 100
			GROUP BY u.id, u.username
			HAVING completed_subtasks > 0 OR u.id IN (SELECT DISTINCT uid FROM subtasks)
			ORDER BY u.username ASC
		");
		$stmt_employee_speed->execute();
		$result_employee_speed = $stmt_employee_speed->get_result();
		$employee_performance_data = $result_employee_speed->fetch_all(MYSQLI_ASSOC);
		$stmt_employee_speed->close();

		// Calculate total completed subtasks and average per employee
		$total_completed_subtasks = 0;
		foreach ($employee_performance_data as $data) {
			$total_completed_subtasks += $data['completed_subtasks'];
		}
		$num_employees_with_subtasks = count($employee_performance_data);
		$average_subtasks_per_employee = ($num_employees_with_subtasks > 0) ? $total_completed_subtasks / $num_employees_with_subtasks : 0;

		echo '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">';
		echo '<thead><tr><th>Pracownik</th><th>Tempo pracy</th><th>Szczegóły</th></tr></thead><tbody>';

		if (empty($employee_performance_data)) {
			echo '<tr><td colspan="3">Brak danych o wykonanych podzadaniach przez pracowników.</td></tr>';
		} else {
			foreach ($employee_performance_data as $employee) {
				$tempo_icon = '';
				$details_text = '';

				// Determine tempo icon
				if ($average_subtasks_per_employee > 0) {
					if ($employee['completed_subtasks'] < $average_subtasks_per_employee * 0.5) {
						$tempo_icon = '🐌 Ślimak (Najwolniejszy)';
					} elseif ($employee['completed_subtasks'] < $average_subtasks_per_employee * 0.8) {
						$tempo_icon = '🐢 Żółw (Powolny)';
					} elseif ($employee['completed_subtasks'] >= $average_subtasks_per_employee * 0.8 && $employee['completed_subtasks'] <= $average_subtasks_per_employee * 1.2) {
						$tempo_icon = '🧍 Człowiek (Przeciętny)';
					} elseif ($employee['completed_subtasks'] > $average_subtasks_per_employee * 1.2) {
						$tempo_icon = '🐆 Puma (Najwydajniejszy)';
					}
				} else {
					$tempo_icon = 'N/A (Brak średniej do porównania)';
				}
				$details_text = 'Zakończonych podzadań: ' . htmlspecialchars($employee['completed_subtasks']) . ' (Średnia: ' . htmlspecialchars(round($average_subtasks_per_employee, 2)) . ').';

				echo '<tr>';
				echo '<td>' . htmlspecialchars($employee['username']) . '</td>';
				echo '<td>' . $tempo_icon . '</td>';
				echo '<td><small>' . $details_text . '</small></td>';
				echo '</tr>';
			}
		}
		echo '</tbody></table>';

	} catch (Exception $e) {
		error_log("Error fetching employee performance: " . $e->getMessage());
		echo '<div class="error">Wystąpił błąd podczas ładowania wizualizacji pracy pracowników.</div>';
	}
}
?>
