<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;
use Forum\Service\Factory\SectionManagerFactory;
use Security\Service\Factory\UserManagerFactory;

class RetrieveOneCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $sectionId;
    
    public function setSectionId($id)
    {
        $this->sectionId = $id;
    }
    
    /**
     * @return \Forum\Model\Entity\Section
     */
    public function execute()
    {
        $sql = "SELECT s.id AS s_id, s.name AS s_name, s.description AS s_description, s.amount_topics AS t_amount_topics, s.is_closed AS s_is_closed, s.created_on AS s_created_on, ";
        $sql .= "u.id AS u_id, u.username AS u_username, u.email AS u_email, u.amount_posts AS u_amount_posts ";
        $sql .= "FROM sections s ";
        $sql .= "INNER JOIN users u on s.user_id = u.id ";
        $sql .= "WHERE s.id = " . $this->escapeString($this->sectionId);

        $row = $this->fetchOne($sql);
        
        if (!$row) {
            return null;
        }
        
        $sectionManager = SectionManagerFactory::create();
        $userManager = UserManagerFactory::create();
        
        $user = $userManager->create($row);
        $section = $sectionManager->create($row);
        $section->setUser($user);
        
        return $section;
        
    }
}

