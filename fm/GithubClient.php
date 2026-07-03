<?php
require_once __DIR__ . '/config.php';

class GitHubClient
{
    private $base;

    public function __construct()
    {
        $this->base = "https://api.github.com/repos/" . GITHUB_OWNER . "/" . GITHUB_REPO . "/";
    }

    private function encodePath($path)
    {
        $path = trim($path, '/');
        if ($path === '') return '';
        $parts = explode('/', $path);
        $parts = array_map('rawurlencode', $parts);
        return implode('/', $parts);
    }

    private function request($method, $endpoint, $data = null)
    {
        $url = $this->base . $endpoint;
        $ch = curl_init($url);

        $headers = [
            'Authorization: token ' . GITHUB_TOKEN,
            'Accept: application/vnd.github+json',
            'User-Agent: PHP-GitHub-FileManager',
            'X-GitHub-Api-Version: 2022-11-28',
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        if ($data !== null) {
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['ok' => false, 'code' => 0, 'error' => $err];
        }

        $decoded = json_decode($response, true);

        return [
            'ok' => $httpCode >= 200 && $httpCode < 300,
            'code' => $httpCode,
            'data' => $decoded,
        ];
    }

    // List isi folder (atau ambil detail 1 file) di path tertentu
    public function listContents($path = '')
    {
        $ep = 'contents/' . $this->encodePath($path) . '?ref=' . urlencode(GITHUB_BRANCH);
        return $this->request('GET', $ep);
    }

    // Ambil isi file (base64 decoded) + sha
    public function getFile($path)
    {
        $res = $this->listContents($path);
        if (!$res['ok'] || !isset($res['data']['content'])) {
            return $res;
        }
        $res['data']['decoded_content'] = base64_decode(str_replace("\n", '', $res['data']['content']));
        return $res;
    }

    // Buat file baru / update file yang sudah ada
    public function createOrUpdateFile($path, $plainContent, $message, $sha = null)
    {
        $ep = 'contents/' . $this->encodePath($path);
        $data = [
            'message' => $message,
            'content' => base64_encode($plainContent),
            'branch' => GITHUB_BRANCH,
        ];
        if ($sha) $data['sha'] = $sha;
        return $this->request('PUT', $ep, $data);
    }

    // Hapus 1 file (butuh sha)
    public function deleteFile($path, $message, $sha)
    {
        $ep = 'contents/' . $this->encodePath($path);
        $data = [
            'message' => $message,
            'sha' => $sha,
            'branch' => GITHUB_BRANCH,
        ];
        return $this->request('DELETE', $ep, $data);
    }

    // Ambil seluruh struktur repo (recursive) via Git Trees API
    public function getFullTree()
    {
        $ep = 'git/trees/' . urlencode(GITHUB_BRANCH) . '?recursive=1';
        return $this->request('GET', $ep);
    }

    // Ambil isi file langsung dari blob sha (lebih efisien dari getFile untuk operasi massal)
    public function getBlob($sha)
    {
        $ep = 'git/blobs/' . $sha;
        $res = $this->request('GET', $ep);
        if ($res['ok'] && isset($res['data']['content'])) {
            $res['data']['decoded_content'] = base64_decode(str_replace("\n", '', $res['data']['content']));
        }
        return $res;
    }

    // Hapus seluruh isi folder (semua blob dengan prefix path/)
    public function deleteFolder($path, $message)
    {
        $path = trim($path, '/');
        $treeRes = $this->getFullTree();
        if (!$treeRes['ok']) return $treeRes;

        $errors = [];
        foreach ($treeRes['data']['tree'] as $item) {
            if ($item['type'] === 'blob' && strpos($item['path'], $path . '/') === 0) {
                $r = $this->deleteFile($item['path'], $message, $item['sha']);
                if (!$r['ok']) $errors[] = $item['path'] . ': ' . json_encode($r['data']);
            }
        }
        return ['ok' => empty($errors), 'errors' => $errors];
    }

    // Rename/pindah 1 file
    public function renameFile($oldPath, $newPath, $message)
    {
        $fileRes = $this->getFile($oldPath);
        if (!$fileRes['ok']) return $fileRes;

        $createRes = $this->createOrUpdateFile($newPath, $fileRes['data']['decoded_content'], $message);
        if (!$createRes['ok']) return $createRes;

        return $this->deleteFile($oldPath, $message, $fileRes['data']['sha']);
    }

    // Rename/pindah seluruh folder (rebuild semua file di path baru, hapus yang lama)
    public function renameFolder($oldPath, $newPath, $message)
    {
        $oldPath = trim($oldPath, '/');
        $newPath = trim($newPath, '/');
        $treeRes = $this->getFullTree();
        if (!$treeRes['ok']) return $treeRes;

        $errors = [];
        foreach ($treeRes['data']['tree'] as $item) {
            if ($item['type'] === 'blob' && strpos($item['path'], $oldPath . '/') === 0) {
                $relative = substr($item['path'], strlen($oldPath) + 1);
                $blobRes = $this->getBlob($item['sha']);
                if (!$blobRes['ok']) {
                    $errors[] = $item['path'] . ': gagal ambil isi file';
                    continue;
                }
                $createRes = $this->createOrUpdateFile($newPath . '/' . $relative, $blobRes['data']['decoded_content'], $message);
                if (!$createRes['ok']) {
                    $errors[] = $item['path'] . ': gagal buat file baru';
                    continue;
                }
                $delRes = $this->deleteFile($item['path'], $message, $item['sha']);
                if (!$delRes['ok']) $errors[] = $item['path'] . ': gagal hapus file lama';
            }
        }
        return ['ok' => empty($errors), 'errors' => $errors];
    }

    public function createFolder($path, $message)
    {
        $path = trim($path, '/');
        return $this->createOrUpdateFile($path . '/.gitkeep', '', $message);
    }
}
