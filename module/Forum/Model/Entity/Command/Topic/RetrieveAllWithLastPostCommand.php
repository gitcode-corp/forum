<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;
use Forum\Service\Factory\SectionManagerFactory;
use Forum\Service\Factory\TopicManagerFactory;
use Forum\Service\Factory\PostManagerFactory;
use Security\Service\Factory\UserManagerFactory;

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
        $sql .= "p.id AS p_id, p.created_on AS p_created_on, ";
        $sql .= "u.id AS u_id, u.username AS u_username, ";
        $sql .= "ut.id AS ut_id, ut.username AS ut_username, ";
        $sql .= "s.id AS s_id ";
        $sql .= "FROM topics t ";
        $sql .= "INNER JOIN sections s on s.id = t.section_id ";
        $sql .= "INNER JOIN users ut on ut.id = t.user_id ";
        $sql .= "LEFT JOIN posts p on p.id = t.last_post_id ";
        $sql .= "LEFT JOIN users u on u.id = p.user_id ";
        $sql .= "WHERE s.id = " . $this->sectionId . " ";
        $sql .= "ORDER BY t.created_on DESC";

        $rows = $this->fetchAll($sql);
        
        $sectionManager = SectionManagerFactory::create();
        $topicManager = TopicManagerFactory::create();
        $postManager = PostManagerFactory::create();
        $userManager = UserManagerFactory::create();

        $collection = [];
        foreach ($rows as $row) {
            $topic = $topicManager->create($row);
            
            $section = $sectionManager->create($row);
            $topic->setSection($section);
            
            $user = $userManager->create();
            $user->setId($row["ut_id"]);
            $user->setUsername($row["ut_username"]);
            $topic->setUser($user);
            
            $post = $postManager->create($row);
            if ($post->getId()) {
                $user = $userManager->create($row);
                $post->setUser($user);
                
                $topic->setLastPost($post);
            }

            $collection[] = $topic;
        }
        
        return $collection;
    }
}

