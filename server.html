<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pterodactyl Server List</title>

<style>
body{
    background:#0f172a;
    color:#fff;
    font-family:Arial;
    padding:30px;
}
button{
    padding:10px 18px;
    cursor:pointer;
}
.server{
    background:#1e293b;
    margin-top:15px;
    padding:15px;
    border-radius:10px;
}
</style>
</head>
<body>

<h2>Server Pterodactyl</h2>

<button onclick="loadServers()">Lihat Server</button>

<div id="servers"></div>

<script>
const PANEL = "https://panel.domainmu.com"; // Ganti
const TOKEN = "ptlc_Law0JKQO2nOrWWV4jhPyHSCe4H78UwvcdznJ1v3nuK1";

async function loadServers(){

    const res = await fetch(`${PANEL}/api/client`,{
        headers:{
            "Authorization":"Bearer "+TOKEN,
            "Accept":"Application/vnd.pterodactyl.v1+json"
        }
    });

    const json = await res.json();

    let html="";

    json.data.forEach(server=>{

        const s = server.attributes;

        html += `
        <div class="server">
            <h3>${s.name}</h3>
            <p><b>ID:</b> ${s.identifier}</p>
            <p><b>UUID:</b> ${s.uuid}</p>
            <p><b>Status:</b> ${s.status ?? "-"}</p>
        </div>
        `;
    });

    document.getElementById("servers").innerHTML = html;
}
</script>

</body>
</html>
