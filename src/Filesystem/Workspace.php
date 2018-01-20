<?php

namespace ADR\Filesystem;

use RuntimeException;

/**
 * Represents the workspace that store the ADRs
 *
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class Workspace
{
    /**
     * @var string
     */
    private $directory;
    
    /**
     * @param string $directory The directory name
     *
     * @throws RuntimeException
     */
    public function __construct(string $directory)
    {
        $this->set($directory);
    }
    
    /**
     * Sets workspace that store the ADRs
     * 
     * @param string $directory The workspace that store the ADRs
     * 
     * @throws RuntimeException
     */
    private function set(string $directory)
    {
        if (! file_exists($directory)) {
            $this->make($directory);
        }
        
        $this->directory = $directory;
    }
    
    /**
     * Returns directory name
     * 
     * @return string The directory name
     */
    public function get() : string
    {
        return $this->directory;
    }

    /**
     * Makes directory
     * 
     * @param string $directory The directory path
     * 
     * @throws RuntimeException When the permissions prevent creating the directory
     */
    private function make(string $directory)
    {
        $parent = dirname($directory);
        
        while (! is_dir($parent)) {
            $parent = dirname($parent);
        }
         
        if (! is_writable($parent)) {
            throw new RuntimeException("The parent directory isn't writable: $parent");
        }
        
        if (! mkdir($directory, 0777, true)) {
            throw new RuntimeException("Illegal directory: $directory");
        }
    }
}