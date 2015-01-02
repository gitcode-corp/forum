<?php

namespace Forum\Model\Entity\Command\Post;

use Soft\AbstractCommand;
use Forum\Service\Factory\TopicManagerFactory;
use Forum\Service\Factory\SectionManagerFactory;
use Security\Service\Factory\UserManagerFactory;
use Forum\Service\Factory\PostManagerFactory;

class RetrieveOneCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $sectionId;
    
    /**
     * @var int
     */
    private $topicId;
    
    /**
     * @var int
     */
    private $postId;
    
    public function setSectionId($id)
    {
        $this->sectionId = $id;
    }
    
    public function setTopicId($id)
    {
        $this->topicId = $id;
    }
    
    public function setPostId($id)
    {
        $this->postId = $id;
    }
    
    public function execute()
    {
        $sql = "SELECT p.id AS p_id, p.content AS p_content, p.is_edited_by_admin AS p_is_edited_by_admin, p.created_on AS p_created_on, ";
        $sql .= "t.id AS t_id, t.name AS t_name, t.description AS t_description, t.amount_posts AS t_amount_posts, t.is_closed AS t_is_closed, t.created_on AS t_created_on, ";
        $sql .= "s.id AS s_id, s.name AS s_name, s.description AS s_description, s.is_closed as s_is_closed, s.created_on AS s_created_on, ";
        $sql .= "u.id AS u_id, u.username AS s_username, u.email as u_email, u.created_on AS u_created_on ";
        $sql .= "FROM posts p ";
        $sql .= "INNER JOIN topics t on t.id = p.topic_id ";
        $sql .= "INNER JOIN sections s on s.id = t.section_id ";
        $sql .= "INNER JOIN users u on u.id = p.user_id ";
        $sql .= "WHERE p.id = " . $this->escapeString($this->postId) . " ";
        $sql .= "AND t.id = " . $this->escapeString($this->topicId) . " ";
        $sql .= "AND s.id = " . $this->escapeString($this->sectionId) . " ";

        $row = $this->fetchOne($sql);
        
        if (!$row) {
            return null;
        }

        $postManager = PostManagerFactory::create();
        $topicManager = TopicManagerFactory::create();
        $sectionManager = SectionManagerFactory::create();
        $userManager = UserManagerFactory::create();

        $user = $userManager->create($row);
        $section = $sectionManager->create($row);
        $topic = $topicManager->create($row);
        $topic->setSection($section);

        $post = $postManager->create($row);
        $post->setTopic($topic);
        $post->setUser($user);
        
        return $post;
    }
}

