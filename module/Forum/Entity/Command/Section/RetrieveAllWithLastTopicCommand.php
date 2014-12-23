<?php

namespace Forum\Entity\Command\Section;

use Forum\Entity\Command\AbstractCommand;
use Forum\Entity\Topic;
use Forum\Entity\Post;
use Forum\Entity\Section;

class RetrieveAllWithLastTopicCommand extends AbstractCommand
{
    public function execute()
    {
        $sql = "SELECT s.id AS s_id, s.name AS s_name, s.description AS s_description, s.amount_topics AS s_amount_topics, ";
        $sql .= "t.name AS t_name, ";
        $sql .= "p.username AS p_username, p.created_on AS p_created_on ";
        $sql .= "FROM sections s ";
        $sql .= "LEFT JOIN topics t on t.section_id = s.last_topic_id ";
        $sql .= "LEFT JOIN posts p on p.topic_id = t.last_post_id ";

        $rows = $this->fetchAll($sql);
        
        $sectionManager = new \Forum\Service\SectionManager();
        $topicManager = new \Forum\Service\TopicManager;
        $postManager = new \Forum\Service\PostManager;
        
        $collection = [];
        foreach ($rows as $row) {
            $post = $postManager->create($row);
            
            $topic = $topicManager->create($row);
            $topic->setLastPost($post);
            
            $section = $sectionManager->create($row);
            $section->setLastTopic($topic);

            $collection[] = $section;
        }
        
        return $collection;
    }
}

