<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;

class RetrieveAllWithLastTopicCommand extends AbstractCommand
{
    public function execute()
    {
        $sql = "SELECT s.id AS s_id, s.name AS s_name, s.description AS s_description, s.amount_topics AS s_amount_topics, ";
        $sql .= "t.id AS t_id, t.name AS t_name, ";
        $sql .= "p.id AS p_id, p.username AS p_username, p.created_on AS p_created_on ";
        $sql .= "FROM sections s ";
        $sql .= "LEFT JOIN topics t on t.id = s.last_topic_id ";
        $sql .= "LEFT JOIN posts p on p.id = t.last_post_id ";

        $rows = $this->fetchAll($sql);
        
        $sectionManager = new \Forum\Service\SectionManager();
        $topicManager = new \Forum\Service\TopicManager;
        $postManager = new \Forum\Service\PostManager;

        $collection = [];
        foreach ($rows as $row) {
            $post = $postManager->create($row);
            if (!$post->getId()) {
                $post = null;
            }
            
            $topic = $topicManager->create($row);
            if ($topic->getId()) {
                $topic->setLastPost($post);
            } else {
                $topic = null;
            }
            
            
            $section = $sectionManager->create($row);
            $section->setLastTopic($topic);

            $collection[] = $section;
        }
        
        return $collection;
    }
}

