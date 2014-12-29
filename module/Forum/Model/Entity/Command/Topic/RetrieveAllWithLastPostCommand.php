<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;

class RetrieveAllWithLastPostCommand extends AbstractCommand
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
        $sql .= "p.id AS p_id, p.username AS p_username, p.created_on AS p_created_on, ";
        $sql .= "s.id AS s_id ";
        $sql .= "FROM topics t ";
        $sql .= "INNER JOIN sections s on s.id = t.section_id ";
        $sql .= "LEFT JOIN posts p on p.id = t.last_post_id ";
        $sql .= "WHERE s.id = " . $this->sectionId . " ";
        $sql .= "ORDER BY t.created_on DESC";

        $rows = $this->fetchAll($sql);
        
        $sectionManager = new \Forum\Service\SectionManager();
        $topicManager = new \Forum\Service\TopicManager;
        $postManager = new \Forum\Service\PostManager;

        $collection = [];
        foreach ($rows as $row) {
            $topic = $topicManager->create($row);
            
            $section = $sectionManager->create($row);
            $topic->setSection($section);
            
            $post = $postManager->create($row);
            if ($post->getId()) {
                $topic->setLastPost($post);
            }

            $collection[] = $topic;
        }
        
        return $collection;
    }
}

