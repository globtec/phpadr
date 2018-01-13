<?php

namespace ADR\Filesystem;

/**
 * Class that defines workspace where the ADRs will be stored
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
     * Set directory
     * 
     * @param string $directory The workspace that store the ADRs
     */
    public function set(string $directory)
    {
        if (! file_exists($directory)) {
            $this->make($directory);
        }
        
        $this->directory = $directory;
    }
    
    /**
     * Get directory
     * 
     * @return string
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
     * @throws \RuntimeException
     */
    private function make(string $directory)
    {
        $parent = dirname($directory);
        
        while (! is_dir($parent)) {
            $parent = dirname($parent);
        }
         
        if (! is_writable($parent)) {
            throw new \RuntimeException("The parent directory isn't writable: $parent");
        }
        
        if (! mkdir($directory, 0777, true)) {
            throw new \RuntimeException("Illegal directory: $directory");
        }
    }
}