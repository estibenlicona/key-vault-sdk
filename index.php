<?php
function kv_imds_token_for_kv(): string {
    // Endpoint IMDS con el recurso de Key Vault
    $url = "http://169.254.169.254/metadata/identity/oauth2/token"
         . "?api-version=2018-02-01"
         . "&resource=" . urlencode("https://vault.azure.net");

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Metadata: true"], // obligatorio
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    // Camino feliz: asumimos que siempre hay un access_token
    return $data["access_token"];
}

// ==== prueba rápida ====
$token = kv_imds_token_for_kv();
echo "Token OK (primeros 80 chars):\n";
echo substr($token, 0, 80) . "...\n";