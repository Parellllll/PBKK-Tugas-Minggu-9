# Menjalankan ketiga aplikasi CodeIgniter 4 secara bersamaan
# Latihan 1 (Biodata Mahasiswa) : http://localhost:8080
# Latihan 2a (SIAKAD)           : http://localhost:8081
# Latihan 2b (Toko Online)      : http://localhost:8082

$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$iniArg = if (Test-Path "$root\tools\php.ini") { "-c `"$root\tools\php.ini`"" } else { "" }

Write-Host "Menjalankan ketiga aplikasi CodeIgniter 4..." -ForegroundColor Cyan

Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$root\Latihan1'; php $iniArg spark serve --port 8080"
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$root\Latihan2\SistemAkademik'; php $iniArg spark serve --port 8081"
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$root\Latihan2\TokoOnline'; php $iniArg spark serve --port 8082"

Write-Host "  - Latihan 1  (Biodata Mahasiswa) : http://localhost:8080" -ForegroundColor Green
Write-Host "  - Latihan 2a (Sistem Akademik)   : http://localhost:8081" -ForegroundColor Green
Write-Host "  - Latihan 2b (Toko Online)       : http://localhost:8082" -ForegroundColor Green

