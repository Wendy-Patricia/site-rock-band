<?php
require_once 'header.php';


// Valores padrão
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Lista de colunas permitidas
$allowed_sorts = ['title', 'artist', 'style'];
$allowed_orders = ['asc', 'desc'];

// Validação de segurança
if (!in_array($sort, $allowed_sorts)) {
    $sort = 'title';
}
if (!in_array($order, $allowed_orders)) {
    $order = 'asc';
}

// Lógica para alternar entre asc/desc
$next_order = $order === 'asc' ? 'desc' : 'asc';

// Símbolos para indicar a ordenação
$sort_symbols = [
    'asc' => ' ▲',
    'desc' => ' ▼'
];

// Consulta SQL
$stmt = $pdo->prepare("SELECT * FROM setlist ORDER BY $sort $order");
$stmt->execute();
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="setlist-container">
    <div class="setlist-header">
        <h1>Setlist</h1>
    </div>
    <table class="setlist-table">
        <thead>
            <tr>
                <th>
                    <a href="?sort=title&order=<?php echo $sort === 'title' ? $next_order : 'asc'; ?>">
                        Title<?php echo $sort === 'title' ? $sort_symbols[$order] : '▲▼'; ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=artist&order=<?php echo $sort === 'artist' ? $next_order : 'asc'; ?>">
                        Artist<?php echo $sort === 'artist' ? $sort_symbols[$order] : '▲▼'; ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=style&order=<?php echo $sort === 'style' ? $next_order : 'asc'; ?>">
                        Style<?php echo $sort === 'style' ? $sort_symbols[$order] :'▲▼'; ?>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody id="setlistTable">
            <?php foreach ($songs as $song): ?>
                <tr>
                    <td><?php echo htmlspecialchars($song['title']); ?></td>
                    <td><?php echo htmlspecialchars($song['artist']); ?></td>
                    <td><?php echo htmlspecialchars($song['style']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
?>


<?php require_once 'footer.php'; ?>