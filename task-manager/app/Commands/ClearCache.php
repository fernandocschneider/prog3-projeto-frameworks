<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ClearCache extends BaseCommand
{
    protected $group       = 'Cache';
    protected $name        = 'cache:clear';
    protected $description = 'Limpa todos os caches da aplicação';

    public function run(array $params)
    {
        $cache = \Config\Services::cache();
        
        $cachePath = WRITEPATH . 'cache/';
        if (is_dir($cachePath)) {
            $this->deleteDirectoryContents($cachePath);
            CLI::write('Cache de arquivos limpo.', 'green');
        }
        
        $sessionPath = WRITEPATH . 'session/';
        if (is_dir($sessionPath)) {
            $this->deleteDirectoryContents($sessionPath);
            CLI::write('Cache de sessão limpo.', 'green');
        }
        
        CLI::write('Todos os caches foram limpos com sucesso!', 'green');
    }
    
    private function deleteDirectoryContents($dir)
    {
        if (!is_dir($dir)) {
            return;
        }
        
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $this->deleteDirectoryContents($path);
                rmdir($path);
            } else {
                unlink($path);
            }
        }
    }
} 