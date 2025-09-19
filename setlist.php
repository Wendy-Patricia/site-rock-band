<?php
require_once 'header.php';

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajout d'une nouvelle chanson
    if (isset($_POST['add_song'])) {
        $title = trim($_POST['songtitle']);
        $artist = trim($_POST['songartist']);
        $style = trim($_POST['songstyle']);
        
        // Validation des champs non vides
        if (!empty($title) && !empty($artist) && !empty($style)) {
            $stmt = $pdo->prepare("INSERT INTO setlist (title, artist, style) VALUES (?, ?, ?)");
            $stmt->execute([$title, $artist, $style]);
            header("Location: " . $_SERVER['PHP_SELF']); // Redirection pour éviter la resoumission
            exit();
        } else {
            $error_message = "Tous les champs doivent être remplis !";
        }
    }
    
    // Modification d'une chanson existante
    if (isset($_POST['edit_song'])) {
        $id = $_POST['song_id'];
        $title = trim($_POST['songtitle']);
        $artist = trim($_POST['songartist']);
        $style = trim($_POST['songstyle']);
        
        // Validation des champs non vides
        if (!empty($title) && !empty($artist) && !empty($style)) {
            $stmt = $pdo->prepare("UPDATE setlist SET title = ?, artist = ?, style = ? WHERE id = ?");
            $stmt->execute([$title, $artist, $style, $id]);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $error_message = "Tous les champs doivent être remplis !";
        }
    }
}

// Suppression d'une chanson
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM setlist WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Valeurs par défaut
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Liste de colonnes et ordres autorisés
$allowed_sorts = ['title', 'artist', 'style'];
$allowed_orders = ['asc', 'desc'];

if (!in_array($sort, $allowed_sorts)) $sort = 'title';
if (!in_array($order, $allowed_orders)) $order = 'asc';

// Alternance asc/desc
$next_order = $order === 'asc' ? 'desc' : 'asc';
$sort_symbols = ['asc' => ' ▲', 'desc' => ' ▼'];

// Requête SQL sécurisée
$stmt = $pdo->prepare("SELECT * FROM setlist ORDER BY $sort $order");
$stmt->execute();
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les données d'une chanson pour l'édition
$edit_song = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM setlist WHERE id = ?");
    $stmt->execute([$id]);
    $edit_song = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="setlist-container">
    <div class="setlist-header">
        <h1>Setlist</h1>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Rechercher..." onkeyup="filterSongs()">
        </div>
    </div>
    
    <?php if (isset($error_message)): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <table class="setlist-table">
        <thead>
            <tr>
                <th><a href="?sort=title&order=<?php echo $sort === 'title' ? $next_order : 'asc'; ?>">Title<?php echo $sort === 'title' ? $sort_symbols[$order] : '▲▼'; ?></a></th>
                <th><a href="?sort=artist&order=<?php echo $sort === 'artist' ? $next_order : 'asc'; ?>">Artist<?php echo $sort === 'artist' ? $sort_symbols[$order] : '▲▼'; ?></a></th>
                <th><a href="?sort=style&order=<?php echo $sort === 'style' ? $next_order : 'asc'; ?>">Style<?php echo $sort === 'style' ? $sort_symbols[$order] : '▲▼'; ?></a></th>

                <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>
                <th colspan="2">
                    <img src="logos/plus.png" alt="Add Song" class="icon" id="openAddModalBtn">
                </th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody id="setlistTable">
            <?php foreach ($songs as $song): ?>
            <tr>
                <td><?php echo htmlspecialchars($song['title']); ?></td>
                <td><?php echo htmlspecialchars($song['artist']); ?></td>
                <td><?php echo htmlspecialchars($song['style']); ?></td>
                <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>
                <td>
                    <img src="logos/editer.png" class="icon" onclick="openEditModal(<?php echo $song['id']; ?>, '<?php echo addslashes($song['title']); ?>', '<?php echo addslashes($song['artist']); ?>', '<?php echo addslashes($song['style']); ?>')">
                </td>
                <td>
                    <img src="logos/trash.png" class="icon" onclick="if(confirm('Are you sure you want to delete this song?')) { window.location.href='?delete=<?php echo $song['id']; ?>'; }">
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal pour l'ajout -->
<div class="modal" id="addModal" style="display:none;">
    <div class="modal-content">
        <h2 style="position: center;">Add Song</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm('add')">
            <input type="hidden" name="add_song" value="1">
            <div class="form-group">
                <input type="text" id="add_songtitle" name="songtitle" placeholder="Song Title" required>
            </div>
            <div class="form-group">
                <input type="text" id="add_songartist" name="songartist" placeholder="Song Artist" required>
            </div>
            <div class="form-group">
                <input type="text" id="add_songstyle" name="songstyle" placeholder="Song Style" required>
            </div>
            <div class="button-group">
                <button type="button" class="cancel-btn" id="closeAddModalBtn">Cancel</button>
                <button type="submit" class="submit-btn">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal pour l'édition -->
<div class="modal" id="editModal" style="display:none;">
    <div class="modal-content">
        <h2>Modifier la chanson</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm('edit')">
            <input type="hidden" name="edit_song" value="1">
            <input type="hidden" id="edit_song_id" name="song_id" value="">
            <div class="form-group">
                <input type="text" id="edit_songtitle" name="songtitle" placeholder="Song Title" required>
            </div>
            <div class="form-group">
                <input type="text" id="edit_songartist" name="songartist" placeholder="Song Artist" required>
            </div>
            <div class="form-group">
                <input type="text" id="edit_songstyle" name="songstyle" placeholder="Song Style" required>
            </div>
            <div class="button-group">
                <button type="button" class="cancel-btn" id="closeEditModalBtn">Cancel</button>
                <button type="submit" class="submit-btn">Modifier</button>
            </div>
        </form>
    </div>
</div>

<script>
function filterSongs() {
    const filter = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#setlistTable tr').forEach(row => {
        const match = Array.from(row.querySelectorAll('td')).some(cell => cell.textContent.toLowerCase().includes(filter));
        row.style.display = match ? '' : 'none';
    });
}

// Modals
const addModal = document.getElementById("addModal");
const editModal = document.getElementById("editModal");
const openAddBtn = document.getElementById("openAddModalBtn");
const closeAddBtn = document.getElementById("closeAddModalBtn");
const closeEditBtn = document.getElementById("closeEditModalBtn");

if (openAddBtn) openAddBtn.addEventListener("click", () => addModal.style.display = "block");
if (closeAddBtn) closeAddBtn.addEventListener("click", () => addModal.style.display = "none");
if (closeEditBtn) closeEditBtn.addEventListener("click", () => editModal.style.display = "none");

// Fermer modals si clic en dehors
window.addEventListener("click", e => {
    if (e.target === addModal) addModal.style.display = "none";
    if (e.target === editModal) editModal.style.display = "none";
});

// Ouvrir modal d'édition avec les données de la chanson
function openEditModal(id, title, artist, style) {
    document.getElementById('edit_song_id').value = id;
    document.getElementById('edit_songtitle').value = title;
    document.getElementById('edit_songartist').value = artist;
    document.getElementById('edit_songstyle').value = style;
    editModal.style.display = "block";
}

function validateForm(type) {
    const title = document.getElementById(type + '_songtitle').value.trim();
    const artist = document.getElementById(type + '_songartist').value.trim();
    const style = document.getElementById(type + '_songstyle').value.trim();
 

    if (!title || !artist || !style) {
        alert("Tous les champs doivent être remplis !");
        return false;
    }

    return true;
}
</script>

<?php require_once 'footer.php'; ?>