<?php

namespace ADR\Domain;

/**
 * Represents the Architecture Decision using text formatting language like Markdown
 * 
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class DecisionRecord
{
    /**
     * Returns the record name
     * 
     * @return string The record name
     */
    public function name() : string
    {
        return '001-foo.md';
    }
    
    /**
     * Returns the content of the ADR
     * 
     * @return string The content
     */
    public function output() : string
    {
        $vars = [
            '<date>' => date('Y-m-d'),
        ];
        
        return str_replace(array_keys($vars), array_values($vars), $this->template());
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