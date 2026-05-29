<?php

$models = [
    'User.php' => 'P1GestionUsuarioSeguridad',
    'Profesor.php' => 'P2GestionProfesoresPostulantes',
    'Postulante.php' => 'P2GestionProfesoresPostulantes',
    'Gestion.php' => 'P3GestionAcademica',
    'Grupo.php' => 'P3GestionAcademica',
    'GrupoMateria.php' => 'P3GestionAcademica',
    'Materia.php' => 'P3GestionAcademica',
    'Carrera.php' => 'P3GestionAcademica',
    'AsignacionCarrera.php' => 'P3GestionAcademica',
    'Examen.php' => 'P4GestionEvaluacionAsistencia',
    'Calificacion.php' => 'P4GestionEvaluacionAsistencia',
    'Asistencia.php' => 'P4GestionEvaluacionAsistencia',
    'Horario.php' => 'P4GestionEvaluacionAsistencia',
    'Pago.php' => 'P5PagosFacturacion',
];

$controllers = [
    'DashboardController.php' => 'P1GestionUsuarioSeguridad',
    'UsuarioController.php' => 'P1GestionUsuarioSeguridad',
    'ProfileController.php' => 'P1GestionUsuarioSeguridad',
    'ProfesorController.php' => 'P2GestionProfesoresPostulantes',
    'PostulanteController.php' => 'P2GestionProfesoresPostulantes',
    'GestionController.php' => 'P3GestionAcademica',
    'GrupoController.php' => 'P3GestionAcademica',
    'ExamenController.php' => 'P4GestionEvaluacionAsistencia',
    'AsistenciaController.php' => 'P4GestionEvaluacionAsistencia',
    'PagoController.php' => 'P5PagosFacturacion',
    'ReporteController.php' => 'P6ReportesComunicaciones',
];

// Move Models
foreach ($models as $file => $module) {
    $src = __DIR__ . '/app/Models/' . $file;
    $destDir = __DIR__ . '/app/Modules/' . $module . '/Models';
    if (!is_dir($destDir)) mkdir($destDir, 0777, true);
    $dest = $destDir . '/' . $file;
    if (file_exists($src)) {
        rename($src, $dest);
        $content = file_get_contents($dest);
        $content = str_replace('namespace App\Models;', 'namespace App\Modules\\' . $module . '\Models;', $content);
        file_put_contents($dest, $content);
        echo "Moved $file to $module\n";
    }
}

// Move Controllers
foreach ($controllers as $file => $module) {
    $src = __DIR__ . '/app/Http/Controllers/' . $file;
    $destDir = __DIR__ . '/app/Modules/' . $module . '/Http/Controllers';
    if (!is_dir($destDir)) mkdir($destDir, 0777, true);
    $dest = $destDir . '/' . $file;
    if (file_exists($src)) {
        rename($src, $dest);
        $content = file_get_contents($dest);
        $content = str_replace('namespace App\Http\Controllers;', 'namespace App\Modules\\' . $module . '\Http\Controllers;', $content);
        file_put_contents($dest, $content);
        echo "Moved $file to $module\n";
    }
}

// Move Services
$src = __DIR__ . '/app/Services/PagoService.php';
$destDir = __DIR__ . '/app/Modules/P5PagosFacturacion/Services';
if (!is_dir($destDir)) mkdir($destDir, 0777, true);
if (file_exists($src)) {
    rename($src, $destDir . '/PagoService.php');
    $content = file_get_contents($destDir . '/PagoService.php');
    $content = str_replace('namespace App\Services;', 'namespace App\Modules\P5PagosFacturacion\Services;', $content);
    file_put_contents($destDir . '/PagoService.php', $content);
    echo "Moved PagoService\n";
}

// Move Contracts
$src = __DIR__ . '/app/Contracts/WalletGatewayInterface.php';
$destDir = __DIR__ . '/app/Modules/P5PagosFacturacion/Contracts';
if (!is_dir($destDir)) mkdir($destDir, 0777, true);
if (file_exists($src)) {
    rename($src, $destDir . '/WalletGatewayInterface.php');
    $content = file_get_contents($destDir . '/WalletGatewayInterface.php');
    $content = str_replace('namespace App\Contracts;', 'namespace App\Modules\P5PagosFacturacion\Contracts;', $content);
    file_put_contents($destDir . '/WalletGatewayInterface.php', $content);
    echo "Moved WalletGatewayInterface\n";
}

// Update Namespaces in all files
$modelNamespaces = [];
foreach ($models as $file => $module) {
    $className = str_replace('.php', '', $file);
    $modelNamespaces['App\Models\\' . $className] = 'App\Modules\\' . $module . '\Models\\' . $className;
}

$controllerNamespaces = [];
foreach ($controllers as $file => $module) {
    $className = str_replace('.php', '', $file);
    $controllerNamespaces['App\Http\Controllers\\' . $className] = 'App\Modules\\' . $module . '\Http\Controllers\\' . $className;
}

$allReplacements = array_merge($modelNamespaces, $controllerNamespaces);
$allReplacements['App\Services\PagoService'] = 'App\Modules\P5PagosFacturacion\Services\PagoService';
$allReplacements['App\Contracts\WalletGatewayInterface'] = 'App\Modules\P5PagosFacturacion\Contracts\WalletGatewayInterface';

$directories = [__DIR__ . '/app', __DIR__ . '/routes', __DIR__ . '/database', __DIR__ . '/tests', __DIR__ . '/config'];
foreach ($directories as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $newContent = str_replace(array_keys($allReplacements), array_values($allReplacements), $content);
            if ($newContent !== $content) {
                file_put_contents($file->getPathname(), $newContent);
            }
        }
    }
}

echo "Refactoring completed successfully.";
