<?php

namespace ADR\Domain;

/**
 * Represents the architecture decision using text formatting language like Markdown
 * 
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class DecisionRecord
{
    /**
     * Suffix to the name
     * 
     * @var string
     */
    const EXTENSION = '.md';
    
    /**
     * @var DecisionContent
     */
    private $content;
    
    /**
     * @param DecisionContent $content
     */
    public function __construct(DecisionContent $content)
    {
        $this->content = $content;
    }
    
    /**
     * Returns the record file name
     * 
     * @return string The file name
     */
    public function filename() : string
    {
        return $this->sequence() . '-' . $this->slug() . self::EXTENSION;
    }
    
    /**
     * Returns the content of the ADR
     * 
     * @return string The content
     */
    public function output() : string
    {
        $vars = [
            '<sequence>' => $this->content->getId(),
            '<title>'    => $this->content->getTitle(),
            '<date>'     => date('Y-m-d'),
            '<status>'   => $this->content->getStatus(),
        ];
        
        return str_replace(array_keys($vars), array_values($vars), $this->template());
    }
    
    /**
     * Returns the number sequentially
     * 
     * @return string The number sequentially
     */
    private function sequence() : string
    {
        return str_pad($this->content->getId(), 3, '0', STR_PAD_LEFT);
    }
    
    /**
     * Returns the title slugged
     *
     * @return string
     */
    private function slug() : string
    {
        $slugged = iconv('UTF-8', 'ASCII//TRANSLIT', $this->content->getTitle());
        $slugged = preg_replace('/[^-\/+|\w ]/', '', $slugged);
        $slugged = strtolower(trim($slugged));
        $slugged = preg_replace('/[\/_|+ -]+/', '-', $slugged);
        
        return trim($slugged, '-');
    }
    
    /**
     * Returns template for ADR
     *
     * @return string
     */
    private function template() : string
    {
        ob_start();
        
        require realpath(__DIR__ . '/../../template/skeleton.md');
        
        return ob_get_clean();
    }
}