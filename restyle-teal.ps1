# A lancer depuis la racine du projet : C:\xampp\htdocs\Dossiers-medicaux
# Remplace la palette indigo (defaut Tailwind) par teal (identite du projet)
# dans tous les fichiers .blade.php sous resources/views

$files = Get-ChildItem -Path "resources\views" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    $original = $content

    $content = $content -replace 'indigo-50',  'teal-50'
    $content = $content -replace 'indigo-100', 'teal-100'
    $content = $content -replace 'indigo-500', 'teal-600'
    $content = $content -replace 'indigo-600', 'teal-700'
    $content = $content -replace 'indigo-700', 'teal-800'
    $content = $content -replace 'indigo-800', 'teal-900'

    if ($content -ne $original) {
        Set-Content -Path $file.FullName -Value $content -Encoding UTF8 -NoNewline
        Write-Host "Modifie : $($file.FullName)"
    }
}

Write-Host "Termine."