<?php

namespace Forum\Model\Entity\Command\Post;

use Soft\AbstractCommand;

class RetrieveAllInTopicCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $sectionId;
    
    /**
     * @var int
     */
    private $topicId;
    
    public function setSectionId($id)
    {
        $this->sectionId = $id;
    }
    
    public function setTopicId($id)
    {
        $this->topicId = $id;
    }
    
    public function execute()
    {
        $sql = "SELECT p.id AS p_id, p.content AS p_content, p.created_on AS p_created_on, ";
        $sql .= "u.id AS u_id, u.username AS u_username, ";
        $sql .= "s.id AS s_id, ";
        $sql .= "t.id AS t_id, t.name AS t_name ";
        $sql .= "FROM posts p ";
        $sql .= "INNER JOIN topics t on t.id = p.topic_id ";
        $sql .= "INNER JOIN sections s on s.id = t.section_id ";
        $sql .= "INNER JOIN users u on u.id = p.user_id ";
        $sql .= "WHERE s.id = " . $this->sectionId . " ";
        $sql .= "AND t.id = " . $this->topicId . " ";
        $sql .= "ORDER BY p.created_on ASC";

        $rows = $this->fetchAll($sql);
        
        $sectionManager = new \Forum\Service\SectionManager();
        $topicManager = new \Forum\Service\TopicManager();
        $postManager = new \Forum\Service\PostManager();
        $userManager = new \Security\Service\UserManager();

        $collection = [];
        foreach ($rows as $row) {
            $section = $sectionManager->create($row);
            
            $topic = $topicManager->create($row);
            $topic->setSection($section);
            
            $user = $userManager->create($row);
            
            $post = $postManager->create($row);
            $post->setTopic($topic);
            $post->setUser($user);

            $collection[] = $post;
        }
        
        return $collection;
    }
}

