<?php
// ====================== CONFIG ======================
define('SUPABASE_URL', 'https://xcxciixqhmghitmyigbj.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhjeGNpaXhxaG1naGl0bXlpZ2JqIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3ODU2MzQ2MCwiZXhwIjoyMDk0MTM5NDYwfQ.Tzg34ww9r2X2WrZ9wcYoajoQUjUfRkOxnsdARskfvJE');

define('PTERO_URL', 'https://hecker.el7.web.id');
define('PLTA', 'ptla_bipLYJE8qGtdUmC9q10yGVOeJgQlxPAaOSFGULJfaMs');

define('EGG_NODEJS', 16);
define('EGG_PYTHON', 17);

define('MAX_RAM', 1024);
define('MAX_DISK', 2000);
define('MAX_CPU', 100);

// ====================== HELPERS ======================
function supabase($method, $endpoint, $body = null) {
    $ch = curl_init(SUPABASE_URL . "/rest/v1/" . $endpoint);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "apikey: " . SUPABASE_KEY,
            "Authorization: Bearer " . SUPABASE_KEY,
            "Prefer: return=representation"
        ],
        CURLOPT_POSTFIELDS => $body ? json_encode($body) : null
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

function ptero($method, $endpoint, $body = null) {
    $ch = curl_init(PTERO_URL . "/api/application/" . $endpoint);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => [
            "Accept: application/vnd.pterodactyl.v1+json",
            "Content-Type: application/json",
            "Authorization: Bearer " . PLTA
        ],
        CURLOPT_POSTFIELDS => $body ? json_encode($body) : null
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// ====================== API CREATE PANEL ======================
if (isset($_POST['create'])) {

    header('Content-Type: application/json');

    $phone = $_POST['phone'] ?? '';
    $token = $_POST['token'] ?? '';
    $script = $_POST['script'] ?? 'nodejs';

    if (!$phone || !$token) {
        echo json_encode(["ok"=>false,"msg"=>"Data kosong"]);
        exit;
    }

    $rd = supabase("GET", "redeems?code=eq.$token");

    if (!$rd || $rd[0]['used']) {
        echo json_encode(["ok"=>false,"msg"=>"Token invalid"]);
        exit;
    }

    if ((time()*1000 - $rd[0]['created_at']) > 600000) {
        echo json_encode(["ok"=>false,"msg"=>"Token expired"]);
        exit;
    }

    $egg = $script === "python" ? EGG_PYTHON : EGG_NODEJS;

    $res = ptero("POST", "servers", [
        "name" => "bot_" . substr($phone, -6),
        "user" => 1,
        "egg" => $egg,
        "docker_image" => "ghcr.io/pterodactyl/yolks:nodejs_16",
        "startup" => "npm start",
        "limits" => [
            "memory" => MAX_RAM,
            "swap" => 0,
            "disk" => MAX_DISK,
            "cpu" => MAX_CPU
        ],
        "feature_limits" => [
            "databases" => 0,
            "allocations" => 1,
            "backups" => 0
        ],
        "deploy" => [
            "locations" => [1],
            "dedicated_ip" => false,
            "port_range" => []
        ],
        "start_on_completion" => true
    ]);

    if (!empty($res['attributes'])) {

        supabase("PATCH", "redeems?code=eq.$token", ["used"=>true]);

        echo json_encode([
            "ok"=>true,
            "server_id"=>$res['attributes']['id']
        ]);
    } else {
        echo json_encode(["ok"=>false,"error"=>$res]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Polar.id — Free Panel</title>

<style>
:root{
--orange:#f6821f;
--bg:#f8fafc;
--card:#ffffff;
--text:#0f172a;
--muted:#64748b;
--border:#e2e8f0;
}

body{
margin:0;
font-family:Inter,system-ui;
background:var(--bg);
color:var(--text);
}

/* SIDEBAR */
.sidebar{
position:fixed;left:0;top:0;bottom:0;
width:240px;background:var(--card);
border-right:1px solid var(--border);
padding:16px;
}

.logo{font-weight:700;margin-bottom:20px}
.nav a{
display:block;
padding:10px;
border-radius:8px;
color:var(--muted);
text-decoration:none;
margin-bottom:6px;
}
.nav a:hover{background:#fff4eb;color:var(--orange)}

/* MAIN */
.main{
margin-left:240px;
padding:24px;
}

.card{
background:var(--card);
border:1px solid var(--border);
border-radius:10px;
padding:20px;
max-width:500px;
}

input,select{
width:100%;
padding:10px;
margin:8px 0;
border:1px solid var(--border);
border-radius:8px;
}

button{
background:var(--orange);
color:white;
border:none;
padding:10px;
width:100%;
border-radius:8px;
cursor:pointer;
font-weight:600;
}

button:hover{background:#e07010}
</style>
</head>

<body>

<div class="sidebar">
<div class="logo">❄️ Polar.id</div>
<div class="nav">
<a href="#">Dashboard</a>
<a href="#">Session</a>
<a href="#">Token</a>
<a href="#">CS</a>
</div>
</div>

<div class="main">

<h2>Free Panel Generator</h2>

<div class="card">

<input id="phone" placeholder="628xxxxxxxx">
<input id="token" placeholder="Token Aktivasi">

<select id="script">
<option value="nodejs">NodeJS</option>
<option value="python">Python</option>
</select>

<button onclick="create()">Buat Panel</button>

</div>

</div>

<script>
async function create(){
let phone=document.getElementById('phone').value
let token=document.getElementById('token').value
let script=document.getElementById('script').value

let res=await fetch('',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:`create=1&phone=${phone}&token=${token}&script=${script}`
})

let data=await res.json()
alert(JSON.stringify(data,null,2))
}
</script>

</body>
</html>