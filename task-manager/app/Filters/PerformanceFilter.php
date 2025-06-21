<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PerformanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        
        if (strpos($path, '/assets/') === 0) {
            $response = service('response');
            $response->setHeader('Cache-Control', 'public, max-age=86400');
            $response->setHeader('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-Frame-Options', 'DENY');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
        
        if (extension_loaded('zlib') && !empty($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
                $response->setHeader('Content-Encoding', 'gzip');
            }
        }
        
        return $response;
    }
} 