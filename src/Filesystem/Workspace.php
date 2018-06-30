<?php

namespace ADR\Filesystem;

use ADR\Domain\DecisionRecord;
use FilesystemIterator;
use SplFileInfo;
use Symfony\Component\Console\Exception\RuntimeException;

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
     * Returns directory name
     *
     * @return string The directory name
     */
    public function get(): string
    {
        return $this->directory;
    }
    
    /**
     * Count the number of ADRs in workspace
     * 
     * @return int The number of ADRs in workspace
     */
    public function count(): int
    {
        return count($this->records());
    }
    
    /**
     * Write a Architecture Decision to a markdown file
     * 
     * @param DecisionRecord $record
     */
    public function add(DecisionRecord $record): void
    {
        file_put_contents($this->filename($record), $record->output());
    }
    
    /**
     * Returns array containing name of the ADRs
     * 
     * @return array
     */
    public function records(): array
    {
        $records = [];
        
        $iterator = new FilesystemIterator($this->get(), FilesystemIterator::SKIP_DOTS);
        
        /* @var $fileInfo SplFileInfo */
        foreach ($iterator as $fileInfo) {
            if ($this->isValidFilename($fileInfo)) {
                array_push($records, $fileInfo->getFilename());
            }
        }
        
        return $records;
    }
    
    /**
     * Sets workspace that store the ADRs
     * 
     * @param string $directory The workspace that store the ADRs
     * 
     * @throws RuntimeException
     */
    private function set(string $directory): void
    {
        if (! file_exists($directory)) {
            $this->make($directory);
        }
        
        $this->directory = $directory;
    }

    /**
     * Makes directory
     * 
     * @param string $directory The directory path
     * 
     * @throws RuntimeException When the permissions prevent creating the directory
     */
    private function make(string $directory): void
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
    
    /**
     * Returns filename 
     * 
     * @param DecisionRecord $record
     * 
     * @return string The filename
     */
    private function filename(DecisionRecord $record): string
    {
        return $this->get() . DIRECTORY_SEPARATOR . $record->filename();
    }
    
    /**
     * Check if filename is valid to ADR
     * 
     * @param SplFileInfo $fileInfo
     * 
     * @return bool
     */
    private function isValidFilename(SplFileInfo $fileInfo): bool
    {
        if (! $fileInfo->isFile()) {
            return false;
        }
        
        $pattern = '/^\d{' . DecisionRecord::NUMBER_LENGTH . '}-[a-z\d\-]+\\' . DecisionRecord::EXTENSION . '$/';
        
        return (boolean) preg_match($pattern, $fileInfo->getFilename());
    }
}