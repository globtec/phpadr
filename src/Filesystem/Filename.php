<?php

namespace ADR\Filesystem;

/**
 * Class that defines the name of the ADRs
 * 
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class Filename
{
    /**
     * @var \ADR\Filesystem\Workspace
     */
    private $workspace;
    
    /**
     * @param \ADR\Filesystem\Workspace $workspace
     */
    public function __construct(Workspace $workspace)
    {
        $this->workspace = $workspace;
    }
    
    /**
     * Get filename 
     * 
     * @param string $title
     * @return string
     */
    public function get(string $title) : string
    {
        return  $this->sequence() . '-' . $this->sluggify($title) . '.md';
    }
    
    /**
     * Create sequence monotonically, numbers will not be reused
     * 
     * @return string
     */
    private function sequence() : string
    {
        $iterator = new \FilesystemIterator($this->workspace->get(), \FilesystemIterator::SKIP_DOTS);

        $sequence = iterator_count($iterator) + 1;
        
        return str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Sluggify the title of the ADR
     * 
     * @param string $title
     * @return string
     */
    private function sluggify(string $title) : string
    {
        $title = iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', $title);
        $title = preg_replace('/[^-\/+|\w ]/', '', $title);
        $title = strtolower(trim($title));
        $title = preg_replace('/[\/_|+ -]+/', '-', $title);

        return trim($title, '-');
    }
}