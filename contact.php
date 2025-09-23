<?php 
require('header.php');

// Buscar o email do admin responsável pelo contato
$sql = "SELECT * FROM admins WHERE contact = 1";
$query = $pdo->prepare($sql);
$query->execute();
$row_count = $query->rowCount();

// Verificar se encontrou o admin de contato
if($row_count != 1) {
    echo "<div class='error-message'>Problema de acesso à base de dados. Contacte o administrador.</div>";
} else { 
    $row = $query->fetch();
    $admin_email = $row["email"];
    
    // Processar o formulário se foi submetido
    $message_sent = false;
    $error = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        
        // Validar os dados
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $error = "Todos os campos são obrigatórios.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Por favor, insira um email válido.";
        } else {
            // Preparar e enviar o email
            $to = $admin_email;
            $email_subject = "Contacto do site: " . $subject;
            $email_body = "
                Nova mensagem de contacto do website.\n\n
                Nome: $name\n
                Email: $email\n
                Assunto: $subject\n\n
                Mensagem:\n$message
            ";
            $headers = "From: $email\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            
            // Tentar enviar o email
            if (mail($to, $email_subject, $email_body, $headers)) {
                $message_sent = true;
            } else {
                $error = "Ocorreu um erro ao enviar a mensagem. Tente novamente mais tarde.";
            }
        }
    }
?>
    <div class="main-container">
        <section class="contact-section">
            <div class="contact-header">
                <h1 class="metal-text">Contact Us</h1>
                <p>Do you have any questions? You need a quote? Send us a message!</p>
            </div>

            <?php if ($message_sent): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <p>Your message has been sent successfully. We'll get back to you soon!</p>
                </div>
            <?php elseif (!empty($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <div class="contact-content">
                <div class="formcontact">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="form-group">
                            <label for="name">Your Name:</label>
                            <input type="text" id="name" name="name" placeholder="Your name" required 
                                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Your Email:</label>
                            <input type="email" id="email" name="email" placeholder="Your email" required
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" id="subject" name="subject" placeholder="The subject of your message" required
                                   value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="message">Your Message:</label>
                            <textarea id="message" name="message" placeholder="Write your message here" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>

                <div class="contact-info">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <div class="info-content">
                            <h3>Location</h3>
                            <p>My Garage, CA 94126, USA</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone fa-2x"></i>
                        </div>
                        <div class="info-content">
                            <h3>Phone</h3>
                            <p>+ 01 234 555 89</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                        <div class="info-content">
                            <h3>Email</h3>
                            <p><?php echo $admin_email; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
}

require('footer.php');
?>
