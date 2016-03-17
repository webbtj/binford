<?php
//Bud

$source_root = './';
$build_root = './';

$phar = new Phar(
    $build_root . 'binford.phar',
    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
    'binford.phar'
);

$binford_php = file_get_contents($source_root . 'binford.php');

$phar['binford.php'] = str_replace('$phar = false;', '$phar = true;', $binford_php);

$partials = new DirectoryIterator($source_root . 'partials/');
foreach($partials as $partial){
    $filename = $partial->getFilename();
    if($partial->isFile())
        $phar['partials/' . $filename] = file_get_contents($source_root . 'partials/' . $filename);
}

$phar->setStub("<?php
    Phar::mount('./', __DIR__);
    Phar::mapPhar();
    include 'phar://binford.phar/binford.php';
    __HALT_COMPILER();
    ?>"
);