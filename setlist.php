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
            <h1>Setlist </h1>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Rechercher..." onkeyup="filterSongs()">
            </div>
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
                            Style<?php echo $sort === 'style' ? $sort_symbols[$order] : '▲▼'; ?>
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

    <script>
        function filterSongs() 
        {
            const input = document.getElementById('searchInput'); //leva o valor que foi digitado na bara de pesquisa
            const filter = input.value.toLowerCase(); // set o valor para minusculas
            const table = document.getElementById('setlistTable'); // captura a tabela
            const rows = table.getElementsByTagName('tr'); //captura todas as linhas da tabela

            for (let i = 0; i < rows.length; i++) 
            {
                const cells = rows[i].getElementsByTagName('td'); //captura todas as celulas da linha
                let match = false;

                for (let j = 0; j < cells.length; j++) // percorre todas as celulas da linha
                {
                    const cell = cells[j];
                    if (cell) //se a celula existe
                    {
                        const textValue = cell.textContent || cell.innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) // indexOf retorna a posicao do valor que foi digitado na barra de pesquisa
                        {
                            match = true;
                            break;
                        }
                    }
                }

                rows[i].style.display = match ? '' : 'none'; //se encontrar o valor digitado na barra de pesquisa, mostra a linha, senao esconde
            }
        }
    </script>

?>


<?php require_once 'footer.php'; ?>