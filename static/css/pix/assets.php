<?php
/**
 * Simple PHP File Manager - single file
 * Features: browse, view, edit, delete, create file/folder, rename, download
 * Security: locked to BASE_PATH; simple password login; CSRF token; no exec
 * Author: ChatGPT
 * Date: 2025-08-20
 */

declare(strict_types=1);
session_start();

/* ===================== CONFIG ===================== */
// Absolute path of the root folder you want to manage.
// Default: the folder where this script is placed.
define('BASE_PATH', realpath(__DIR__));

// Set a strong password. Example: 'minha_senha_super_forte_2025'
// If left empty (""), no login will be required (NOT RECOMMENDED).
define('PASSWORD', ''); // <-- TROQUE AQUI

// Max file size (in bytes) allowed for editing in the browser (avoid huge files)
define('MAX_EDIT_BYTES', 2 * 1024 * 1024); // 2MB

// Timezone for timestamps
date_default_timezone_set('America/Sao_Paulo');
/* ================================================== */

// --------- Helpers (security) ---------
function ensure_logged_in(): void {
    if (PASSWORD === '') return;
    if (!isset($_SESSION['fm_logged_in']) || $_SESSION['fm_logged_in'] !== true) {
        show_login();
        exit;
    }
}

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function check_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $posted = $_POST['csrf'] ?? '';
        if (!$posted || !hash_equals($_SESSION['csrf'] ?? '', $posted)) {
            http_response_code(400);
            exit('CSRF inválido.');
        }
    }
}

/**
 * Resolve a user-provided path (relative to BASE_PATH) safely.
 * Returns [absolutePath, relativePath] or exits on violation.
 */
function resolve_path(string $rel = ''): array {
    $rel = ltrim($rel, '/');
    $target = BASE_PATH . DIRECTORY_SEPARATOR . $rel;
    $real = realpath($target);
    // If path doesn't exist yet (e.g., creating a new file), use dirname for check
    if ($real === false) {
        $realBase = realpath(dirname($target));
        if ($realBase === false || strncmp($realBase, BASE_PATH, strlen(BASE_PATH)) !== 0) {
            http_response_code(403);
            exit('Caminho fora do diretório permitido.');
        }
        // Return intended absolute (not real) and normalized relative
        return [$target, $rel];
    }
    if (strncmp($real, BASE_PATH, strlen(BASE_PATH)) !== 0) {
        http_response_code(403);
        exit('Acesso negado fora do diretório raiz.');
    }
    // Build normalized relative from BASE_PATH
    $relNorm = ltrim(str_replace('\\', '/', substr($real, strlen(BASE_PATH))), '/');
    return [$real, $relNorm];
}

function is_text_file(string $path): bool {
    if (is_dir($path)) return false;
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $textExts = [
        'txt','md','log','env','ini','conf','cfg',
        'html','htm','css','js','ts','json','xml','yml','yaml',
        'php','phtml','twig','blade.php','py','rb','go','java','c','cpp','cs','rs','sh','bash','sql'
    ];
    if (in_array($ext, $textExts, true)) return true;
    // Heuristic: read first bytes and check for nulls
    $fh = @fopen($path, 'rb');
    if (!$fh) return false;
    $chunk = fread($fh, 1024);
    fclose($fh);
    return strpos($chunk, "\0") === false;
}

function delete_recursive(string $path): bool {
    if (is_file($path) || is_link($path)) {
        return @unlink($path);
    }
    if (is_dir($path)) {
        $items = scandir($path);
        if ($items === false) return false;
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            if (!delete_recursive($path . DIRECTORY_SEPARATOR . $item)) return false;
        }
        return @rmdir($path);
    }
    return false;
}

function human_filesize(int $bytes): string {
    $units = ['B','KB','MB','GB','TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units)-1) {
        $bytes /= 1024;
        $i++;
    }
    return sprintf('%.2f %s', $bytes, $units[$i]);
}

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function breadcrumb(string $rel): string {
    $parts = $rel === '' ? [] : explode('/', $rel);
    $crumbs = [];
    $acc = '';
    $crumbs[] = '<a href="?">/</a>';
    foreach ($parts as $p) {
        if ($p === '') continue;
        $acc = ltrim($acc . '/' . $p, '/');
        $crumbs[] = '<a href="?path=' . urlencode($acc) . '">' . e($p) . '</a>';
    }
    return implode(' <span class="slash">/</span> ', $crumbs);
}

// --------- Actions ---------
check_csrf();

if (isset($_POST['action']) && $_POST['action'] === 'login' && PASSWORD !== '') {
    $pass = $_POST['password'] ?? '';
    if (hash_equals(PASSWORD, $pass)) {
        $_SESSION['fm_logged_in'] = true;
        header('Location: ?');
        exit;
    } else {
        show_login('Senha incorreta.');
        exit;
    }
}

ensure_logged_in();

$rel = $_GET['path'] ?? '';
[$abs, $relNorm] = resolve_path($rel);
$action = $_GET['action'] ?? '';

// POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paction = $_POST['action'] ?? '';
    switch ($paction) {
        case 'save':
            $editPathRel = $_POST['edit_path'] ?? '';
            [$editAbs] = resolve_path($editPathRel);
            if (!is_file($editAbs)) { http_response_code(404); exit('Arquivo não encontrado.'); }
            $content = $_POST['content'] ?? '';
            if (file_put_contents($editAbs, $content) === false) {
                $msg = 'Falha ao salvar.';
            } else {
                $msg = 'Arquivo salvo com sucesso.';
            }
            header('Location: ?path=' . urlencode($editPathRel) . '&msg=' . urlencode($msg));
            exit;
        case 'create_file':
            $newName = trim($_POST['new_name'] ?? '');
            if ($newName === '') { $err = 'Nome inválido.'; redirect_with_msg($relNorm, $err); }
            [$targetAbs] = resolve_path($relNorm . '/' . $newName);
            if (file_exists($targetAbs)) { $err = 'Já existe um arquivo/pasta com esse nome.'; redirect_with_msg($relNorm, $err); }
            if (@file_put_contents($targetAbs, '') === false) { $err = 'Não foi possível criar o arquivo.'; redirect_with_msg($relNorm, $err); }
            redirect_with_msg($relNorm, 'Arquivo criado.');
        case 'create_folder':
            $newName = trim($_POST['new_name'] ?? '');
            if ($newName === '') { $err = 'Nome inválido.'; redirect_with_msg($relNorm, $err); }
            [$targetAbs] = resolve_path($relNorm . '/' . $newName);
            if (file_exists($targetAbs)) { $err = 'Já existe um arquivo/pasta com esse nome.'; redirect_with_msg($relNorm, $err); }
            if (!@mkdir($targetAbs, 0775)) { $err = 'Não foi possível criar a pasta.'; redirect_with_msg($relNorm, $err); }
            redirect_with_msg($relNorm, 'Pasta criada.');
        case 'rename':
            $oldRel = $_POST['old_rel'] ?? '';
            $newName = trim($_POST['new_name'] ?? '');
            if ($newName === '') { redirect_with_msg($relNorm, 'Nome inválido.'); }
            [$oldAbs, $oldNorm] = resolve_path($oldRel);
            $newRel = trim(dirname($oldNorm), '/');
            $newRel = ($newRel ? $newRel . '/' : '') . $newName;
            [$newAbs] = resolve_path($newRel);
            if (file_exists($newAbs)) { redirect_with_msg($relNorm, 'Destino já existe.'); }
            if (!@rename($oldAbs, $newAbs)) { redirect_with_msg($relNorm, 'Falha ao renomear.'); }
            $parentRel = trim(dirname($newRel), '/');
            header('Location: ?path=' . urlencode($parentRel));
            exit;
        default:
            // no-op
            break;
    }
}

// GET actions
if ($action === 'download') {
    if (!is_file($abs)) { http_response_code(404); exit('Arquivo não encontrado.'); }
    $filename = basename($abs);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . rawurlencode($filename) . '"');
    header('Content-Length: ' . filesize($abs));
    readfile($abs);
    exit;
}

if ($action === 'delete') {
    if (!file_exists($abs)) { http_response_code(404); exit('Não encontrado.'); }
    if (!delete_recursive($abs)) {
        redirect_with_msg(trim(dirname($relNorm), '/'), 'Falha ao deletar.');
    } else {
        redirect_with_msg(trim(dirname($relNorm), '/'), 'Removido com sucesso.');
    }
}

if ($action === 'edit') {
    if (!is_file($abs)) { http_response_code(404); exit('Arquivo não encontrado.'); }
    show_editor($abs, $relNorm);
    exit;
}

if ($action === 'view') {
    if (!is_file($abs)) { http_response_code(404); exit('Arquivo não encontrado.'); }
    show_viewer($abs, $relNorm);
    exit;
}

// Default: list directory
if (!file_exists($abs)) {
    http_response_code(404);
    exit('Caminho não encontrado.');
}
if (!is_dir($abs)) {
    // If it's a file without explicit action, go to viewer
    header('Location: ?action=view&path=' . urlencode($relNorm));
    exit;
}
show_listing($abs, $relNorm);
exit;

// --------- UI Renderers ---------
function show_login(string $error = ''): void {
    $csrf = csrf_token();
    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Login - Gerenciador de Arquivos</title>';
    echo base_styles();
    echo '</head><body><div class="container">';
    echo '<h1>🔒 Login</h1>';
    if ($error) echo '<div class="alert error">'.e($error).'</div>';
    echo '<form method="post" class="card">';
    echo '<input type="hidden" name="action" value="login"><input type="hidden" name="csrf" value="'.$csrf.'">';
    echo '<label>Senha</label><input type="password" name="password" class="input" autofocus>';
    echo '<button class="btn">Entrar</button>';
    echo '</form>';
    echo '</div></body></html>';
}

function show_listing(string $absDir, string $relDir): void {
    $items = @scandir($absDir);
    $csrf = csrf_token();
    $msg = $_GET['msg'] ?? '';
    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Gerenciador de Arquivos</title>';
    echo base_styles();
    echo '</head><body><div class="container">';
    echo '<h1>📂 Gerenciador de Arquivos</h1>';
    echo '<div class="crumbs">'.breadcrumb($relDir).'</div>';
    if ($msg) echo '<div class="alert success">'.e($msg).'</div>';
    echo '<div class="actions">';
    echo '<form method="post" class="inline"><input type="hidden" name="csrf" value="'.$csrf.'"><input type="hidden" name="action" value="create_file">';
    echo '<input class="input" type="text" name="new_name" placeholder="novo_arquivo.txt"> <button class="btn">➕ Criar arquivo</button></form> ';
    echo '<form method="post" class="inline"><input type="hidden" name="csrf" value="'.$csrf.'"><input type="hidden" name="action" value="create_folder">';
    echo '<input class="input" type="text" name="new_name" placeholder="nova_pasta"> <button class="btn">📁 Criar pasta</button></form>';
    echo '</div>';
    echo '<table class="table"><thead><tr><th>Nome</th><th>Tamanho</th><th>Modificado</th><th>Ações</th></tr></thead><tbody>';
    if ($relDir !== '') {
        $parentRel = trim(dirname($relDir), '/');
        echo '<tr><td colspan="4"><a href="?path='.urlencode($parentRel).'">⬅️ Voltar</a></td></tr>';
    }
    if ($items) {
        foreach ($items as $it) {
            if ($it === '.' || $it === '..') continue;
            $rel = ($relDir ? $relDir.'/' : '') . $it;
            [$abs] = resolve_path($rel);
            $isDir = is_dir($abs);
            $size = $isDir ? '-' : human_filesize((int)@filesize($abs));
            $mtime = date('Y-m-d H:i', (int)@filemtime($abs));
            echo '<tr>';
            echo '<td>'.($isDir ? '📁 ' : '📄 ').'<a href="?path='.urlencode($rel).'">'.e($it).'</a></td>';
            echo '<td>'.$size.'</td>';
            echo '<td>'.$mtime.'</td>';
            echo '<td class="actions-cell">';
            if ($isDir) {
                echo '<a class="btn-sm" href="?path='.urlencode($rel).'">Abrir</a>';
            } else {
                echo '<a class="btn-sm" href="?action=view&path='.urlencode($rel).'">Ver</a> ';
                echo '<a class="btn-sm" href="?action=edit&path='.urlencode($rel).'">Editar</a> ';
                echo '<a class="btn-sm" href="?action=download&path='.urlencode($rel).'">Baixar</a> ';
            }
            // rename form
            echo '<form method="post" class="inline">';
            echo '<input type="hidden" name="csrf" value="'.$csrf.'">';
            echo '<input type="hidden" name="action" value="rename">';
            echo '<input type="hidden" name="old_rel" value="'.e($rel).'">';
            echo '<input class="input input-sm" type="text" name="new_name" placeholder="Renomear: '.e($it).'">';
            echo '<button class="btn-sm">Renomear</button>';
            echo '</form> ';
            echo '<a class="btn-sm danger" href="?action=delete&path='.urlencode($rel).'" onclick="return confirm(\'Tem certeza que deseja remover? Esta ação não pode ser desfeita.\')">Excluir</a>';
            echo '</td>';
            echo '</tr>';
        }
    }
    echo '</tbody></table>';
    echo '<footer class="muted">Raiz: '.e(BASE_PATH).'</footer>';
    echo '</div></body></html>';
}

function show_viewer(string $abs, string $rel): void {
    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Visualizar '.e(basename($abs)).'</title>';
    echo base_styles();
    echo '</head><body><div class="container">';
    echo '<h1>👀 Visualizar: '.e(basename($abs)).'</h1>';
    echo '<div class="crumbs">'.breadcrumb($rel).'</div>';
    echo '<div class="actions"><a class="btn" href="?path='.urlencode(trim(dirname($rel), '/')).'">⬅️ Voltar</a> ';
    echo '<a class="btn" href="?action=download&path='.urlencode($rel).'">Baixar</a> ';
    echo '<a class="btn" href="?action=edit&path='.urlencode($rel).'">Editar</a></div>';
    if (is_text_file($abs) && filesize($abs) <= MAX_EDIT_BYTES) {
        $content = @file_get_contents($abs);
        echo '<pre class="viewer">'.e($content ?? '').'</pre>';
    } else {
        $size = human_filesize((int)@filesize($abs));
        echo '<p class="muted">Pré-visualização indisponível (arquivo binário ou grande). Tamanho: '.$size.'</p>';
    }
    echo '</div></body></html>';
}

function show_editor(string $abs, string $rel): void {
    $size = (int)@filesize($abs);
    if ($size > MAX_EDIT_BYTES) {
        header('Location: ?action=view&path='.urlencode($rel).'&msg='.urlencode('Arquivo muito grande para editar no navegador.'));
        exit;
    }
    if (!is_text_file($abs)) {
        header('Location: ?action=view&path='.urlencode($rel).'&msg='.urlencode('Arquivo binário não é editável.'));
        exit;
    }
    $content = @file_get_contents($abs);
    $csrf = csrf_token();
    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Editando '.e(basename($abs)).'</title>';
    echo base_styles();
    echo '<style>.editor{width:100%;height:70vh;white-space:pre;}</style>';
    echo '</head><body><div class="container">';
    echo '<h1>✏️ Editar: '.e(basename($abs)).'</h1>';
    echo '<div class="crumbs">'.breadcrumb($rel).'</div>';
    echo '<form method="post">';
    echo '<input type="hidden" name="csrf" value="'.$csrf.'">';
    echo '<input type="hidden" name="action" value="save">';
    echo '<input type="hidden" name="edit_path" value="'.e($rel).'">';
    echo '<textarea class="editor input" name="content">'.e($content ?? '').'</textarea>';
    echo '<div class="actions"><a class="btn" href="?action=view&path='.urlencode($rel).'">Cancelar</a> <button class="btn">💾 Salvar</button></div>';
    echo '</form>';
    echo '</div></body></html>';
}

function redirect_with_msg(string $rel, string $msg): void {
    header('Location: ?path='.urlencode($rel).'&msg='.urlencode($msg));
    exit;
}

function base_styles(): string {
    return <<<CSS
<style>
:root{--bg:#0b0f14;--card:#121926;--muted:#8aa0b5;--text:#e6eef8;--accent:#45b97c;--danger:#e05d5d;}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--text);font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,"Helvetica Neue",Arial,"Noto Sans",sans-serif}
.container{max-width:1100px;margin:24px auto;padding:0 16px}
h1{font-weight:700;font-size:22px;margin:0 0 16px}
.card{background:var(--card);padding:16px;border-radius:16px;box-shadow:0 6px 24px rgba(0,0,0,.2)}
.table{width:100%;border-collapse:collapse;background:var(--card);border-radius:16px;overflow:hidden}
.table th,.table td{padding:12px 14px;border-bottom:1px solid rgba(255,255,255,.06);text-align:left;font-size:14px}
.table thead th{font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.06em}
.table tr:hover{background:rgba(255,255,255,.03)}
.input{background:#0f1520;border:1px solid rgba(255,255,255,.1);color:var(--text);border-radius:10px;padding:10px 12px;outline:none}
.input:focus{border-color:var(--accent)}
.input-sm{padding:6px 8px;font-size:12px;width:180px;margin-right:6px}
.btn{background:var(--accent);color:#0b0f14;border:none;border-radius:12px;padding:10px 14px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-block}
.btn:hover{filter:brightness(1.05)}
.btn-sm{background:rgba(255,255,255,.08);color:var(--text);border:none;border-radius:10px;padding:6px 10px;font-size:12px;text-decoration:none;display:inline-block;margin-right:6px}
.btn-sm:hover{background:rgba(255,255,255,.14)}
.btn-sm.danger{background:rgba(224,93,93,.16)}
.btn-sm.danger:hover{background:rgba(224,93,93,.26)}
.inline{display:inline-flex;gap:8px;align-items:center;margin:8px 8px 8px 0}
.actions{margin:14px 0}
.actions-cell{white-space:nowrap}
.alert{padding:10px 12px;border-radius:12px;margin:10px 0}
.alert.success{background:rgba(69,185,124,.15);border:1px solid rgba(69,185,124,.5)}
.alert.error{background:rgba(224,93,93,.15);border:1px solid rgba(224,93,93,.5)}
.crumbs{color:var(--muted);margin-bottom:10px}
.crumbs a{color:#b9d7ff;text-decoration:none}
.crumbs .slash{opacity:.5;margin:0 6px}
.viewer{background:var(--card);padding:16px;border-radius:16px;overflow:auto;max-height:70vh}
footer.muted{color:var(--muted);margin-top:16px;font-size:12px}
label{font-size:14px;margin-bottom:6px;display:block;color:var(--muted)}
</style>
CSS;
}
