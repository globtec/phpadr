<?php

namespace ADR\Domain;

use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * Representes value object of the architecture decision
 * 
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class DecisionContent
{
    /**
     * @var integer
     */
    const TITLE_MAX_LENGTH = 100;
    
    /**
     * If the project stakeholders haven't agreed with it yet
     * 
     * @var string
     */
    const STATUS_PROPOSED = 'Proposed';
    
    /**
     * Once it is agreed
     * 
     * @var string
     */
    const STATUS_ACCEPTED = 'Accepted';
    
    /**
     * If a later ADR changes or reverses a decision to declined
     * 
     * @var string
     */
    const STATUS_REJECTED = 'Rejected';
    
    /**
     * If a later ADR changes or reverses a decision to deprecated
     * 
     * @var string
     */
    const STATUS_DEPRECATED = 'Deprecated';
    
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $title;
    
    /**
     * @var string
     */
    private $status;
    
    /**
     * @param int    $id
     * @param string $title
     * @param string $status
     *
     * @throws InvalidArgumentException
     */
    public function __construct(int $id, string $title, string $status = self::STATUS_ACCEPTED)
    {
        $this->id = $id;
        
        $this->setTitle($title);
        $this->setStatus($status);
    }
    
    /**
     * Returns the number of the ADR
     * 
     * @return int ID value
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Returns the title
     * 
     * @return string The title
     */
    public function getTitle() : string
    {
        return $this->title;
    }
    
    /**
     * Returns the status
     * 
     * @return string The status
     */
    public function getStatus() : string
    {
        return $this->status;
    }
    
    /**
     * Set title
     *
     * @param string $title Must be short noun phrases
     *
     * @throws InvalidArgumentException
     */
    private function setTitle(string $title)
    {
        if (strlen($title) > self::TITLE_MAX_LENGTH) {
            $message = sprintf(
                'The title must be less than %d characters',
                self::TITLE_MAX_LENGTH
            );
            
            throw new InvalidArgumentException($message);
        }
        
        $this->title = $title;
    }
    
    /**
     * Set status 
     * 
     * @param string $status Decision status
     *
     * @throws InvalidArgumentException
     */
    private function setStatus(string $status)
    {
        $map = [
            self::STATUS_PROPOSED,
            self::STATUS_ACCEPTED,
            self::STATUS_REJECTED,
            self::STATUS_DEPRECATED,
        ];
        
        if (! in_array($status, $map)) {
            $message = sprintf(
                'Invalid status "%s". Available status: [%s]',
                $status,
                implode(', ', $map)
            );
            
            throw new InvalidArgumentException($message);
        }
        
        $this->status = $status;
    }
}