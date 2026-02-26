

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="icon" type="image/x-icon" href="icons/laundry.png">
    <title>Laundry Control</title>
</head>
<body>

    <!-- Verificação de Erro de Login -->
    <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function( ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Acesso Negado',
                    text: 'Usuário ou senha incorretos. Por favor, tente novamente.',
                    confirmButtonColor: '#00b3ff',
                    background: '#151515',
                    color: '#fff'
                });
            });
        </script>
    <?php endif; ?>

    <div class="login-container">
        <div class="card login-card">
            <div class="login-header">
                <img src="icons/laundry.png" alt="Logo" class="login-logo">
                <h1>Laundry <span>Control</span></h1>
                <p>Acesse para gerenciar</p>
            </div>

            <form action="config/login.php" method="post" class="login-form">
                <div class="input-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Digite seu usuário" required>
                </div>

                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="btn-login">Entrar</button>
                
            </form>
        </div>
    </div>

</body>
</html>