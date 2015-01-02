<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;
use Forum\Service\Factory\SectionManagerFactory;
use Forum\Service\Factory\TopicManagerFactory;

class RetrieveAllInSectionCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $sectionId;
    
    public function setSectionId($id)
    {
        $this->sectionId = $id;
    }
    
    public function execute()
    {
        $sql = "SELECT t.id AS t_id, t.name AS t_name, t.amount_posts AS t_amount_posts, t.created_on AS t_created_on, ";
        $sql .= "s.id AS s_id ";
        $sql .= "FROM topics t ";
        $sql .= "INNER JOIN sections s on s.id = t.section_id ";
        $sql .= "WHERE s.id = " . $this->escapeString($this->sectionId) . " ";

        $rows = $this->fetchAll($sql);
        
        $sectionManager = SectionManagerFactory::create();
        $topicManager = TopicManagerFactory::create();

        $collection = [];
        foreach ($rows as $row) {
            $topic = $topicManager->create($row);
            
            $section = $sectionManager->create($row);
            $topic->setSection($section);
            
            $collection[] = $topic;
        }
        
        return $collection;
    }
}

